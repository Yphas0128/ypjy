<?php

namespace App\Http\Controllers;

use App\Model\Hook;
use Illuminate\Http\Request;

class HookController extends Controller
{
    //
    public function add(Request $request){
        $data = $request->all();
        if($hook = Hook::create($data)){
            return response()->json(['msg' => "接口添加成功"]);
        }
        return  response()->json(['msg' => "接口添加失败"],401);
    }


    public function getdata(Request $request){
        $size  = $request->input('size');
        if($data = Hook::paginate($size)){
            return response()->json(['data'=>$data]);
        }
    }
}
