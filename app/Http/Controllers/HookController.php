<?php

namespace App\Http\Controllers;

use App\Model\Hook;
use App\Model\Rolehook;
use Illuminate\Http\Request;

class HookController extends BaseapiController
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

    //

    public function gethook(Request $request){
        $id = $request->input('id');
        $hooks = Rolehook::where('rId',$id)->pluck('url');
        return response()->json(['data'=>$this->getRouteList(),'hooks'=>$hooks]);
    }
}
