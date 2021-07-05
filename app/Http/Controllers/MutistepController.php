<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

class MutistepController extends Controller
{
    public function getData(Request $request)
    {
		$inputs = $request->all();
		print_r($inputs);
		die;
        return view('application');
    }
}
