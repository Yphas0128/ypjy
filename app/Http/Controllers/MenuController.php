<?php

namespace App\Http\Controllers;

use App\Model\JwtUser;
use App\Model\Menu;
use App\Services\JwtService;
use App\Traits\Common;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class MenuController extends Controller
{
    use Common;
    protected  $service = null;

    public function __construct(){
        $this->service = new JwtService();
    }

    public function add(Request $request){
        $this->validate($request, [
            'title' => 'required|unique:menus,title',
        ]);
        $data = $request->all();
        if($menu = Menu::create($data)){
            return response()->json(['msg' => "菜单添加成功"]);
        }
        return  response()->json(['msg' => "菜单添加失败"],403);

    }


    public function getinfo(){
        $data = Menu::all();
        $datas = getTree($data);
        foreach ($datas as $k => $v){
            $datas[$k]['title'] = str_repeat('——',$v['lev']).' '.$v['title'];
        }
        return response()->json(['data'=>$datas]);
    }

    public function getdata(){
        $data = Menu::all();
        $datas = getChild($data);
        return response()->json(['data'=>$datas]);
    }

    //页面数据
    public function menus(Request $request){
        $user = auth()->getUser();
        $model = new JwtUser();
        $menus = $model->getmenus($user['id']);
        $data = $this->getMenus($menus);
        $urls =  app()->routes->getRoutes();
        $arrs = [];
        foreach ($urls as $value) {
            if(!$value->uri || $value->uri === '/') {
                continue;
            }
            $arrs[] = $value->uri;
        };
        return response()->json(['data'=>$data]);
    }

}
