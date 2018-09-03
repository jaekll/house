<?php
/**
 *异常处理
 * author:luohz
 */

namespace app\common\exception;

use Exception;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\ValidateException;
use think\facade\App;
use think\facade\Config;
use think\facade\Log;

class Http extends Handle {

    public function render(Exception $e)
    {
        $return = [];
        //debug模式输出行号，文件名
        if (config('app_debug')){
            $return['line'] = $e->getLine();
            $return['file'] = $e->getFile();
            $return['trace'] = $e->getTraceAsString();
            $return['time'] = App::getBeginTime();
        }
        //校验异常
        if ($e instanceof ValidateException){
            $return['code']= $e->getCode();
            $return['msg'] = $e->getMessage();
            $return['data'] = '';
            return json($return,200);
        }

        //http异常
        if ($e instanceof HttpException){
            $return['code']= $e->getStatusCode();
            $return['msg'] = $e->getMessage();
            $return['data'] = '';
            return json($return,200);
        }

        //其他异常交给系统处理
        //return parent::render($e);
        //Log::write('发生错误：'.$e->getMessage().' || 文件名：'.$e->getFile().'第'.$e->getLine().'行',\think\Log::ERROR);
        $return['code']= 500;
        $return['msg'] = App::isDebug()?$e->getMessage():"error";
        $return['data'] = '';
        return json($return,500);
    }
}