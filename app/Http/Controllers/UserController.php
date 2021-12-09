<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|email',
            'phone'=>'required',
            'password'=>'required'
        ]);
        if ($validator->fails()){
            return response()->json(['status'=>'failed', 'validation_errors'=>$validator->errors()]);
        }
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);
        if(!is_null($user)){
            return response()->json(['status'=>'success','message'=>'user registered successfully completed']);
        }else{
            return response()->json(['status'=>'failed','message'=>'user registration failed']);
        }
    }
}
