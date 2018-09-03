<?php
/**
 * 用户模型
 * 前后台共享
 */
namespace app\common\model;

use think\db\exception\DataNotFoundException;
use think\exception\DbException;
use think\Model;

class User extends Model{

    protected $readonly = ['register','mobile'];


    const STATUS_ACTIVE    = '0';   //状态:正常
    const STATUS_FORBIDDEN = '1';  //状态：禁用
    const STATUS_DELETE    = '2';   //状态:删除
    const USER_CACHE_KEY = 'zpf_robot_user_';//单用户缓存key前缀
    const USERS_CACHE_KEY = 'zpf_robot_users';//用户集缓存key
    /**
     * 添加一个账户
     * */
    public function addUser($user){

        return User::insert($user);
    }

    /**
     * 通过ID查找用户
     *
     * */
    public function getUser($id){
        $cache_key = User::USER_CACHE_KEY.$id;
        return User::where('id',$id)->field('id,username,email,mobile,password,status')
            ->cache($cache_key,3600)->find();
    }

    /**
     * 通过用户名找用户
     * @param $username string
     * @return Model
     * @throws DataNotFoundException
     * @throws DbException
     *
     * */
    public function getUserByName($username){
        $cache_key = User::USER_CACHE_KEY.$username;
        return User::where('username',$username)->field('id,username,email,mobile,password,status')
            ->cache($cache_key,3600)->find();
    }

    /**
     * 通过邮箱查找用户
     * @param $email string
     * @return Model
     * @throws DataNotFoundException
     * @throws DbException
     *
     * */
    public function getUserByEmail($email){
        $cache_key = User::USER_CACHE_KEY.$email;
        return User::where('email',$email)->field('id,username,email,mobile,password,status')
            ->cache($cache_key,3600)->find();
    }

    /**
     * 通过邮箱查找用户
     * @param $email string
     * @return Model
     * @throws DataNotFoundException
     * @throws DbException
     *
     * */
    public function getUserByMobile($mobile){
        $cache_key = User::USER_CACHE_KEY.$mobile;
        return User::where('mobile',$mobile)->field('id,username,email,mobile,password,status')
            ->cache($cache_key,3600)->find();
    }

    /**
     * 分页获取账户
     * */
    public function getUsersByPage($page=1,$pageSize=15){
        $offset = ($page - 1) * $pageSize;
        return User::order('id','asc')->field('id,username,email,mobile,password,status')
            ->cache(USERS_CACHE_KEY,3600)
            ->limit($offset,$pageSize)->select();
    }
}