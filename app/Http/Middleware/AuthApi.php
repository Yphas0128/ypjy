<?php

namespace App\Http\Middleware;
use App\Model\Rolehook;
use Auth;
use App\Model\JwtUser;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AuthApi extends  BaseMiddleware
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
            //需要判断是否有权限
            if(!$this->hasPermission($user,$route_data)){
                return response()->json([
                    'code' => 1004,
                    //'msg' => '用户不存在'
                    'msg'=>'您没有权限！'
                ],402);
            }

        }catch (TokenExpiredException $e){
            //token已过期 刷新?

            try{
                $token = Auth::guard('apijwt')->refresh();
                // 使用一次性登录以保证此次请求的成功
                Auth::guard('apijwt')->onceUsingId($this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()['sub']);
            }catch (JWTException $e){
                return response()->json([
                    'code' => 1002,
                    'msg' => $e->getMessage() , //token 无法刷新
                ],403);
            }
            return $this->setAuthenticationHeader($next($request), $token);
        }catch (TokenInvalidException $e){
            if(in_array($url,['refresh'])){
                //刷新token
                return $next($request);
            }
            return response()->json([
                'code' => 1002,
                'msg' => '请先登录' , //token已过期
            ],403);
        }catch (JWTException $e){
            return response()->json([
                'code' => 1001,
                //'msg' => '缺少token' , //token为空
                'msg'=>'请先登录！'
            ],400);
        }

        return $next($request);
    }


    //判断是否有权限
    protected  function hasPermission($user,$route){
        $uri = $route->uri;
        $users_model = new JwtUser();
        $rh_model    = new Rolehook();
        $userInfo = $users_model->where('id',$user['id'])->select('role_id')->first()->toArray();
        if($data = $rh_model->where('url',$uri)->where('rId',$userInfo['role_id'])->get()->toArray()){
            return true;
        }else{
            return false;
        }
    }
}
