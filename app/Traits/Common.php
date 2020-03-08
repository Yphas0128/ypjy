<?php


    namespace App\Traits;


    Trait Common{

        public  function getMenus($data,$pid=0){
            $tree = [];
            foreach ($data as $k => $v){
                if($v['pid'] == $pid){
                    $v['children'] =  $this->getMenus($data,$v['id']);
                    if(!$v['children']){
                        unset($v['children']);
                    }
                    $tree[] = $v;
                }
            }
            return $tree;
        }

        public function getpsrr($data,$pId){
            $tree = [];
            $tree[] = $pId;
            foreach ($data as $k => $v){
                if($v['pid'] == $pId){
                    $this->getpsrr($data,$v['id']);
                    $tree[] = $v['id'];
                }
            }
            return $tree;
        }
    }