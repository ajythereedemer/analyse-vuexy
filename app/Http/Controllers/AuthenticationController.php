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
use App\Models\MultiStepMaster;
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
		
		$data = [];
		if(isset($inputs['id']))
		{
			//$data['created_by'] = $input['created_by'] ?? 0;
			$data['title'] = $inputs['title'];
			$data['updated_at'] = Carbon::now();
			$multiStep = MultiStepMaster::find($inputs['id']);
			$multiStep->update($data);
		}
		else
		{
			$data['title'] = $inputs['title'];
			//$data['created_by'] = $input['created_by'] ?? 0;
			$data['created_at'] = Carbon::now();
			$insertData = MultiStepMaster::insert($data);
			$inputs['id'] = \DB::getPdo()->lastInsertId();
		}
		$data = [];
		
		$ids = [];
		$extension = [];
		foreach($inputs['data'] as $index=>$input)
		{
			$data = [
				"step_name"=>$input['step_name'] ?? "",
				"title"=>$input['title'] ?? "",
				"master_id"=>$inputs['id'] ?? "",
				"description"=>$input['description'] ?? "",
				"content_url"=>$input['content_url'] ?? "",
				"button_text"=>$input['button_text'] ?? "",
			];
			
			$filePath = "";
			if(isset($inputs['image'][$index]))
			{
				$image = $inputs['image'][$index];
				$extension = explode('/', mime_content_type($image))[1];
				if($extension == "jpeg"){
					$image = str_replace('data:image/jpeg;base64,', '', $image);
				}else if($extension == "png"){
					$image = str_replace('data:image/png;base64,', '', $image);
				}else{
					$image = str_replace('data:image/svg+xml;base64,', '', $image);
				}
				
				$image = str_replace(' ', '+', $image);
				$filePath = "images/image-".time().".".$extension;
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
		MultiStep::whereNotIn('id', $ids)->where(['master_id'=>$inputs['id']])->delete();

		return response()->json($extension);
    }
	
	public function getFormData(Request $request,$id)
    {
		$inputs = $request->all();
		$multiStep = MultiStepMaster::with('steps')->where(["id"=>$id])->first();

		return response()->json(compact('multiStep'));
    }
	
	public function getTableData(Request $request)
    {
		$inputs = $request->all();
		$multiStep = MultiStepMaster::withCount('steps')->orderBy('id', 'DESC')->get();

		return response()->json(compact('multiStep'));
    }
	
	public function deleteData(Request $request,$id)
    {	
		MultiStepMaster::where(['id'=>$id])->delete();
		MultiStep::where(['master_id'=>$id])->delete();
		
		return true;
    }
}
