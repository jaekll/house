<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Headers:token');
header('Access-Control-Allow-Headers:Content-Type');
header('Access-Control-Allow-Methods:PUT, GET, POST, DELETE, OPTIONS');

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    echo 'options ok';
    return;
}


//定义当前运行环境
define('RUN_ENV','DEV');
// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';

// 支持事先使用静态方法设置Request对象和Config对象

// 执行应用并响应
Container::get('app')->run()->send();
