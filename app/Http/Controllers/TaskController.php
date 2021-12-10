<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class TaskController extends Controller
{
    public function index(){
        //check user login
        $user = Auth::user();
        if(!is_null($user)){
            $tasks = Task::where('user_id', $user->id)->get();
            if(count($tasks) > 0){
                return response()->json(['status'=>'success','count'=>count($tasks),'data'=>$tasks ],200);
            }else{
                return response()->json(['status'=>'failed','message' =>'Task not found!'],200);
            }
        }
    }
    public function store(Request $request){
        $authUser = Auth::user();
        if(!is_null($authUser)){
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'description'=>'required'
                ]);
            if($validator->fails()){
                return response()->json(['status' =>'failed','validation_error' => $validator->errors()]);
            }
            $inputs = $request->all();
            $inputs['user_id'] = $authUser->id;
            $task = Task::create($inputs);
            if(!is_null($task)){
                return response()->json(['status'=> 'success','message'=>'task successfully created'],201);
            }else{
                return response()->json(['status'=>'failed','message'=>'Whoops!task create failed!']);
            }
        }
    }





}
