<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27
 * Time: 13:21
 */
namespace app\admin\middleware;

use app\admin\service\Rbac;
use traits\controller\Jump;

class AdminAuth{

    use Jump;

    public function handle($request,\Closure $next){

        //前置中间件，对每个请求进行检查
        if (!Rbac::instance()->notNeedLogin()){
            //没有用户信息则跳转至登录页面
            Rbac::instance()->admin() || $this->redirect('account/login');
            //服务器保存了用户信息，进行用户权限检查
            Rbac::instance()->check() || $this->error('你没有权限');
        }

        return $next($request);
    }
}