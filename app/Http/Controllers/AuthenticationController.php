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
		//MultiStep::delete();
		MultiStep::query()->truncate();

		foreach($inputs['data'] as $input)
		{
			$data = [
				"step_name"=>$input['step_name'] ?? "",
				"title"=>$input['title'] ?? "",
				"description"=>$input['description'] ?? "",
				"created_by"=>$input['created_by'] ?? 0,
				"image"=>$input['image'] ?? "",
			];
			MultiStep::insert($data);
		}
		
		print_r($request->file('files'));
		die;
    }
}
