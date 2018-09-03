<?php
/**
 * 账户验证器
 * Date: 2018/6/12
 * Time: 16:12
 */
namespace app\admin\validate;

use think\Validate;

class Account extends Validate{

    protected $rule = [
        'username'=>'require|max:20',
        'password'=>'require',
        'email'=>'require|email',
    ];

    protected $message = [
        'username.require'=>'用户名必须',
        'username.max'=>'用户名不能超过20个字',
        'password.require'=>'密码必须',
        'email.require'=>'邮箱必须',
        'email.email'=>'邮箱格式不正确',
    ];
}