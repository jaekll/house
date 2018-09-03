<?php
/**
 * 账户相关
 * Date: 2018/6/12
 * Time: 15:12
 */
namespace app\admin\controller;



use app\admin\model\Admin;
use app\admin\service\Rbac;
use think\exception\HttpException;
use think\exception\ValidateException;
use think\facade\Log;
use think\facade\Request;
use \app\admin\validate\Account as ValidateAccount;
use think\facade\Validate;

class Account extends Base {

    protected  $request;
    public function __construct(\think\Request $request)
    {
        $this->request = $request;
    }

    public function login(){
        $userModel = model('User');
        $param = $this->param;
        $username = $param['username'];
        $password = $param['password'];
        $verifyCode = !empty($param['verifyCode'])? $param['verifyCode']: '';
        $isRemember = !empty($param['isRemember'])? $param['isRemember']: '';
        $data = $userModel->login($username, $password, $verifyCode, $isRemember);
        if (!$data) {
            return json(['error' => $userModel->getError()]);
        } 
        return json(['data' => $data]);
    }

    public function relogin()
    {   
        $userModel = model('User');
        $param = $this->param;
        $data = decrypt($param['rememberKey']);
        $username = $data['username'];
        $password = $data['password'];

        $data = $userModel->login($username, $password, '', true, true);
        if (!$data) {
            return json(['error' => $userModel->getError()]);
        } 
        return json(['data' => $data]);
    }    

    public function register(Request $request){
        Log::info('用户注册');
        $data = $request::getInput();
        $data = json_decode($data,true);
        $validate = new ValidateAccount();
        if (!$validate->check($data)){
            throw new HttpException(422,$validate->getError());
        }
        return json(['code'=>200,'msg'=>'ok','token'=>$request::token()]);
    }

    public function logout(){
        $param = $this->param;
        cache('Auth_'.$param['authkey'], null);
        return json(['data'=>'退出成功']);
    }

    public function getConfigs()
    {
        $systemConfig = cache('DB_CONFIG_DATA'); 
        if (!$systemConfig) {
            //获取所有系统配置
            $systemConfig = model('admin/SystemConfig')->getDataList();
            cache('DB_CONFIG_DATA', null);
            cache('DB_CONFIG_DATA', $systemConfig, 36000); //缓存配置
        }
        return json(['data' => $systemConfig]);
    }

    public function getVerify()
    {
        $captcha = new HonrayVerify(config('captcha'));
        return $captcha->entry();
    }

    public function setInfo()
    {
        $userModel = model('User');
        $param = $this->param;
        $old_pwd = $param['old_pwd'];
        $new_pwd = $param['new_pwd'];
        $auth_key = $param['auth_key'];
        $data = $userModel->setInfo($auth_key, $old_pwd, $new_pwd);
        if (!$data) {
            return json(['error' => $userModel->getError()]);
        } 
        return json(['data' => $data]);
    }

    // miss 路由：处理没有匹配到的路由规则
    public function miss()
    {
        if (Request::instance()->isOptions()) {
            return ;
        } else {
            echo 'vuethink接口';
        }
    }
}