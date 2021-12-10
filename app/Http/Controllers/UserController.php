<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
se Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;
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
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'failed','validation_errors'=>$validator->errors()]);
        }
        $user = User::where('email',$request->email)->first();
        if(is_null($user)){
            return response()->json(['status'=> 'failed','message'=> 'Failed! User not found!']);
        }
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return response()->json(['status'=> 'success','login'=>true ,'token'=>$token,'data'=>$user]);
        }else{
            return response()->json(['status'=>'failed','login'=>false,'message'=>'Woops! Invalid password' ]);
        }
    }
}
