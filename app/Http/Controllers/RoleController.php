<?php

namespace App\Http\Controllers;

use App\Model\Menu;
use App\Model\Role;
use App\Traits\Common;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //

    use Common;

    public function options(){
        $data = Role::select('id','name as label')->get();
        return response()->json(['data'=>$data]);
    }

    public function rights(Request $request){
        $id = $request->input('currentId');
        $auth = $request->input("ids");
        //更新
        Role::where('id',$id)->update(['auth'=>$auth]);
        return response()->json(['result'=>'success','msg'=>'更新成功']);
    }


    public function gettree(){
        $meus = Menu::select("id",'pid','title as label')->get();
        $data =$this->getMenus($meus);
        return response()->json(['data'=>$data]);

    }

    public function getdata(){
        $roles = Role::all();
        foreach ($roles as $k => $v){
            if($v['auth']){
                $data = Menu::whereIn('id',explode(",",$v['auth']))->get();
                $roles[$k]['auth'] = $this->getMenus($data);
            }else{
                $roles[$k]['auth'] = [];
            }

        }
        return response()->json(['data'=>$roles]);
    }


    public function del(Request $request){
        $id = $request->input('id');
        $rId = $request->input('rId');
        //需要找出所有子集
        $datas = Menu::get(['id','pid']);
        $arr = $this->getpsrr($datas,$id);
        $auth = Role::where('id',$rId)->first(['auth']);
        $collection = collect(explode(',',$auth['auth']));
        $diff = $collection->diff($arr)->all();
        Role::where('id',$rId)->update(['auth'=>join(',',$diff)]);
        $data = Menu::whereIn('id',$diff)->get();
        $data = $this->getMenus($data);
        return response()->json(['data'=>$data]);

    }

}
