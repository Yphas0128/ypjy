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
