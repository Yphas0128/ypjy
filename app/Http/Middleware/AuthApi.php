<?php

namespace App\Http\Middleware;

use App\Model\JwtUser;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     *
     * jwt 登录中间件
     */
    public function handle($request, Closure $next)
    {

        $route_data = $request->route();
        $url = str_replace($route_data->getAction()['prefix'] . '/',"",$route_data->uri);
        $url_arr = ['login'];
        if(in_array($url,$url_arr)){
            return $next($request);
        }

        try{
            //获取到用户数据，并赋值给$user
            if(!$user = JWTAuth::parseToken()->authenticate()){
                //验证错误
                return response()->json([
                    'code' => 1004,
                    //'msg' => '用户不存在'
                    'msg'=>'请先登录！'
                ],400);
            }
/*            $pre = "api/jwt/common";
            $model = new JwtUser();
            $urls = $model->allowedUrl($user['id']);
            if($route_data->getAction()['prefix']!= $pre && !in_array($route_data->getAction()['prefix'],$urls)){
                return response()->json([
                    'code' => 1006,
                    'msg'=>'无权限！'
                ],402);

            }*/
        }catch (TokenExpiredException $e){
            //token已过期
            return response()->json([
                'code' => 1003,
                'msg' => 'token 过期' , //token已过期
            ],400);
        }catch (TokenInvalidException $e){
            if(in_array($url,['refresh'])){
                //刷新token
                return $next($request);
            }
            return response()->json([
                'code' => 1002,
                'msg' => '请先登录' , //token已过期
            ],400);
        }catch (JWTException $e){
            return response()->json([
                'code' => 1001,
                //'msg' => '缺少token' , //token为空
                'msg'=>'请先登录！'
            ],400);
        }

        return $next($request);
    }
}
