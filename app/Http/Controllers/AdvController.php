<?php

namespace App\Http\Controllers;



use App\Http\Controllers\crontab\CosController;
use App\Model\Advposition;
use App\Tools\Uploads;
use Illuminate\Http\Request;

class AdvController extends Controller
{
    //上传图片
    public function upload(Request $request){
      $up = new CosController();
      $up->add_cos();

    }
    //获取数据
    public function getdata(){
        $data = Advposition::all();
        return response()->json(['data'=>$data]);
    }

    //添加
    public function add(Request $request){
        //验证?
        $this->validate($request, [
            'name' => 'required|unique:advpositions,name',
        ]);
        $data = $request->all();
        if( Advposition::create($data)){
            return response()->json(['msg' => "菜单添加成功"]);
        }
        return  response()->json(['msg' => "菜单添加失败"],403);
    }
}
