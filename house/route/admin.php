<?php
/**
 * 后台路由配置文件
 * Date: 2018/6/12
 * Time: 11:30
 */
use think\facade\Route;

Route::any('/',function(){
    return 'hi';
});
//登录路由
Route::any('admin/account/login','admin/Account/login');

//后台分组路由
Route::group('admin',function (){

    //权限分组
    Route::get('groups/list','admin/Groups/index');
    Route::get('groups/read','admin/Groups/read');
    Route::post('groups/save','admin/Groups/save');
    Route::put('groups/edit','admin/Groups/edit');
    Route::delete('groups/del','admin/Groups/delete'); 
    //权限规则
    Route::get('rules/read','admin/Rules/read');
    Route::post('rules/save','admin/Rules/save');
    Route::put('rules/edit','admin/Rules/edit');
    Route::delete('rules/del','admin/Rules/delete');
    Route::delete('rules/dels','admin/Rules/deletes');
    Route::put('rules/enables','admin/Rules/enables');
    Route::get('rules/list','admin/Rules/index');
    //用户
    Route::get('user/read','admin/user/read');
    Route::post('user/save','admin/user/save');
    Route::put('user/edit','admin/user/edit');
    Route::delete('user/del','admin/user/delete');
    Route::delete('user/dels','admin/user/deletes');
    Route::put('user/enables','admin/user/enables');
    Route::get('user/list','admin/Rules/index');
    //菜单
    Route::get('menus/read','admin/menus/read');
    Route::post('menus/save','admin/menus/save');
    Route::put('menus/edit','admin/menus/edit');
    Route::delete('menus/del','admin/menus/delete');
    Route::delete('menus/dels','admin/menus/deletes');
    Route::put('menus/enables','admin/menus/enables');
    Route::get('menus/list','admin/menus/index');
    //系统配置
    Route::get('config/save','admin/config/save');

    Route::post('account/register','admin/Account/register');

});