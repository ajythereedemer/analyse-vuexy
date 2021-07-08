<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\JWTManager as JWT;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\Request;
use App\Models\MultiStep;
use Carbon\Carbon;

class AuthenticationController extends Controller
{
    //
     //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ( ! $token = JWTAuth::attempt($credentials)) {
                return response([
                    'status' => 'error',
                    'error' => 'invalid.credentials',
                    'msg' => 'Invalid Credentials.'
                ], 400);
        }
        return response()->json(compact('token'));
    }

    public function user(Request $request)
    { 
        try{
            if(!$user = JWTAuth::parseToken()->authenticate()){
                return response()->json(['user_not_found'], 400);
            }
        }catch (TokenExpiredException $e){
            return response()->json(['token_expired'], $e->getStatusCode());
        }catch (TokenInvalidException $e){
            return response()->json(['token_invalid'], $e->getStatusCode());
        }catch (JWTException $e){
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
    
    public function refresh()
    {
        return response([
                'status' => 'success'
            ]);
    }
	
	public function getData(Request $request)
    {
		$inputs = $request->all();
		//print_r($inputs['data']);die;
		//MultiStep::query()->truncate();
		
		$ids = [];
		foreach($inputs['data'] as $index=>$input)
		{
			$data = [
				"step_name"=>$input['step_name'] ?? "",
				"title"=>$input['title'] ?? "",
				"description"=>$input['description'] ?? "",
			];
			
			$filePath = "";
			if(isset($inputs['image'][$index]))
			{
				$image = $inputs['image'][$index];
				$image = str_replace('data:image/png;base64,', '', $image);
				$image = str_replace(' ', '+', $image);
				$filePath = "images/image-".time().".png";
				\File::put(public_path(). '/' . $filePath, base64_decode($image));
				
				$data['image'] = '/'.$filePath;
			}
			if(isset($input['created_by']))
			{
				$data['created_by'] = $input['created_by'] ?? 0;
				$data['updated_at'] = Carbon::now();
				$ids[] = $input['id'];
				$multiStep = MultiStep::find($input['id']);
				$multiStep->update($data);
			}
			else
			{
				$data['created_by'] = $input['created_by'] ?? 0;
				$data['created_at'] = Carbon::now();
				$insertData = MultiStep::insert($data);
				$ids[] = \DB::getPdo()->lastInsertId();
			}
		}
		MultiStep::whereNotIn('id', $ids)->delete();
		print_r($ids);die;
    }
	
	public function getFormData(Request $request)
    {
		$inputs = $request->all();
		$multiStep = MultiStep::get();

		return response()->json(compact('multiStep'));
    }
}
