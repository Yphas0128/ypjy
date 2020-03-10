<?php
// 递归无线树状结构
    function getChild($data,$pid=0){
        $arr = [];
        foreach($data as $v){
            if($v['pid']==$pid){
                $rs = getChild($data,$v['id']);
                if(!empty($rs)){
                    $v['children'] = $rs;
                }
                $arr[] = $v;
            }
        }
        return $arr;
    }


    // 递归无线树状结构
    function getTree($data,$pid=0,$lev=0){
        static $arr = [];
        foreach($data as $v){
            if($v['pid']==$pid){
                $v['lev'] = $lev;
                $arr[] = $v;
                getTree($data,$v['id'],$lev+1);
            }
        }
        return $arr;
    }