<?php
/*
*基础公共类
**/
namespace app\admin\controller;

use \think\Controller;

class Base extends Controller{
    
    public function ok($data,$msg='ok'){
        return json(['data'=>$data,'code'=>200,'msg'=>$msg]);    
    }

    public function err($msg='error',$code=400){
        return json(['data'=>[],'code'=>200,'msg'=>$msg]);  
    }
}