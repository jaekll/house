<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/25
 * Time: 15:42
 */
//绑定实例到容器
bind([
   'rbac'=>\app\admin\service\Rbac::class,
]);