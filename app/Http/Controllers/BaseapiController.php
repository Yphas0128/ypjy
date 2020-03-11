<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseapiController extends Controller
{


    public function getRouteList(){
        $app = app();
        $routes = $app->routes->getRoutes();
        $path = [];
        foreach ($routes as $k=>$value){
            $path[$k]['uri'] = $value->uri;
            //$path[$k]['path'] = $value->methods[0];
        }
        return $path;
    }

}
