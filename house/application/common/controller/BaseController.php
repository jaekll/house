<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 9:54
 */
namespace app\common\controller;

class BaseController{

    /**
     * 正常返回
     * @param $data mixed
     * @return string json
     * */
    public function success($data = []){
        return json(['code'=>200,'msg'=>'ok','data'=>$data]);
    }

    /**
     * 返回错误情况
     * @param $msg string //错误描述
     * @return String json
     * */
    public function error($msg = 'err'){
        return json(['code'=>400,'msg'=>$msg,'data'=>'']);
    }
}