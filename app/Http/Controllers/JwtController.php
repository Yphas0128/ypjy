<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Model\JwtUser;
use App\Services\JwtService;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtController extends Controller
{
    //
   // protected $guard = 'apijwt';
    protected  $service = null;

    public function __construct(){
        $this->service = new JwtService();
    }

    public function editrole(Request $request){
        $id = $request->input('id');
        $rId = $request->input('role');
        JwtUser::where('id',$id)->update(['role_id'=>$rId]);
        return response()->json(['result'=>'success','msg'=>'更新成功']);
    }


    public  function edit(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        if(false === JwtUser::where('id',$id)->update(['name'=>$name,'email'=>$email])){
            return response()->json(['msg'=>'编辑失败'],401);
        }
        $data = JwtUser::find($id);
         return response()->json(['msg'=>"操作成功",'user'=>$data]);

    }

    public function change(Request $request){
        $id     = $request->input('id');
        $status = $request->input('status');
        if(false === JwtUser::where('id',$id)->update(['status'=>$status])){
            return response()->json(['msg'=>'操作失败'],401);
        }
        return response()->json(['msg'=>"操作成功"]);
    }

    public function del(Request $request){
        $id = $request->input('id');
        if(JwtUser::destroy($id)){
            return response()->json(['msg'=>'删除成功']);
        }
        return response()->json(['msg'=>'删除失败'],401);
    }
    //搜寻用户
    public function getsearch(Request $request){
        $val   = $request->input("val");
        $size  = $request->input('size');

        if($data = JwtUser::where('name',"like","%".$val."%")->paginate($size)){
            return response()->json(['user'=>$data]);
        }
    }


    /**
     * @param Request $request
     * 添加用户
     */
    public function add(UserRequest $request){
        $credentials = [
            'name'=> $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ];
        if($user = JwtUser::create($credentials)){
           return response()->json(['msg'=>'创建成功']);
        }
        return response()->json(['msg'=>'创建失败']);
    }




    //得到users 数据  需要在 请求中加page
    public function getdata(Request $request){
        $index = $request->input('index');
        $size  = $request->input('size');

        if($data = JwtUser::paginate($size)){
            return response()->json(['user'=>$data]);
        }
    }


    /*注册*/
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
        ]);
        $credentials = [
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
        ];
        $user = JwtUser::create($credentials);
        if($user)
        {
            $token = JWTAuth::fromUser($user);
            return response()->json(['result' => $token]);
        }

    }


    /*登录*/
    public function login(Request $request)
    {

        $credentials = $request->only('name','password');
        if($data = $this->service->set_toke($credentials)){
            return response()->json($data);
        }else{
            return response()->json(['result'=>false]);
        }

    }
}
