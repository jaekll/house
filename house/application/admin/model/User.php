<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\common\lib\Tree;
use think\Db;

class User extends Base
{

    protected $name = 'admin_user';
    protected $createTime = 'create_time';
    protected $updateTime = false;
    protected $autoWriteTimestamp = true;
    protected $insert = [
        'status' => 1,
    ];
    /**
     * 获取用户所属所有用户组
     * @param  array   $param  [description]
     */
    public function groups()
    {
        return $this->belongsToMany('Group', 'admin_access', 'group_id', 'user_id');
    }

    /**
     * [getDataList 列表]
     * @param     [string]                   $keywords [关键字]
     * @param     [number]                   $page     [当前页数]
     * @param     [number]                   $limit    [t每页数量]
     * @return    [array]                             [description]
     */
    public function getDataList($keywords, $page, $limit)
    {
        $map = [];
        if ($keywords) {
            $map['username|realname'] = ['like', '%'.$keywords.'%'];
        }

        // 默认除去超级管理员
        $map['user.id'] = array('neq', 1);
        $dataCount = $this->alias('user')->where($map)->count('id');

        $list = $this
            ->where($map)
            ->alias('user')
            ->join('__ADMIN_STRUCTURE__ structure', 'structure.id=user.structure_id', 'LEFT')
            ->join('__ADMIN_POST__ post', 'post.id=user.post_id', 'LEFT');

        // 若有分页
        if ($page && $limit) {
            $list = $list->page($page, $limit);
        }

        $list = $list
            ->field('user.*,structure.name as s_name, post.name as p_name')
            ->select();

        $data['list'] = $list;
        $data['dataCount'] = $dataCount;

        return $data;
    }

    /**
     * [getDataById 根据主键获取详情]
     * @param     string                   $id [主键]
     * @return    [array]
     */
    public function getDataById($id = '')
    {
        $data = $this->get($id);
        if (!$data) {
            $this->error = '暂无此数据';
            return false;
        }
        $data['groups'] = $this->get($id)->groups;
        return $data;
    }
    /**
     * 创建用户
     * @param  array   $param  [description]
     */
    public function createData($param)
    {
        if (empty($param['groups'])) {
            $this->error = '请至少勾选一个用户组';
            return false;
        }

        // 验证
        $validate = validate($this->name);
        if (!$validate->check($param)) {
            $this->error = $validate->getError();
            return false;
        }

        $this->startTrans();
        try {
            $param['password'] = user_md5($param['password']);
            $this->data($param)->allowField(true)->save();

            foreach ($param['groups'] as $k => $v) {
                $userGroup['user_id'] = $this->id;
                $userGroup['group_id'] = $v;
                $userGroups[] = $userGroup;
            }
            Db::name('admin_access')->insertAll($userGroups);

            $this->commit();
            return true;
        } catch(\Exception $e) {
            $this->rollback();
            $this->error = '添加失败';
            return false;
        }
    }

    /**
     * 通过id修改用户
     * @param  array   $param  [description]
     */
    public function updateDataById($param, $id)
    {
        // 不能操作超级管理员
        if ($id == 1) {
            $this->error = '非法操作';
            return false;
        }
        $checkData = $this->get($id);
        if (!$checkData) {
            $this->error = '暂无此数据';
            return false;
        }
        if (empty($param['groups'])) {
            $this->error = '请至少勾选一个用户组';
            return false;
        }
        $this->startTrans();

        try {
            Db::name('admin_access')->where('user_id', $id)->delete();
            foreach ($param['groups'] as $k => $v) {
                $userGroup['user_id'] = $id;
                $userGroup['group_id'] = $v;
                $userGroups[] = $userGroup;
            }
            Db::name('admin_access')->insertAll($userGroups);

            if (!empty($param['password'])) {
                $param['password'] = user_md5($param['password']);
            }
            $this->allowField(true)->save($param, ['id' => $id]);
            $this->commit();
            return true;

        } catch(\Exception $e) {
            $this->rollback();
            $this->error = '编辑失败';
            return false;
        }
    }

    /**
     * [login 登录]
     * @param     [string]                   $u_username [账号]
     * @param     [string]                   $u_pwd      [密码]
     * @param     [string]                   $verifyCode [验证码]
     * @param     Boolean                  	 $isRemember [是否记住密码]
     * @param     Boolean                    $type       [是否重复登录]
     * @return    [type]                               [description]
     */
    public function login($username, $password, $verifyCode = '', $isRemember = false, $type = false)
    {
        if (!$username) {
            $this->error = '帐号不能为空';
            return false;
        }
        if (!$password){
            $this->error = '密码不能为空';
            return false;
        }
        if (config('IDENTIFYING_CODE') && !$type) {
            if (!$verifyCode) {
                $this->error = '验证码不能为空';
                return false;
            }
            $captcha = new HonrayVerify(config('captcha'));
            if (!$captcha->check($verifyCode)) {
                $this->error = '验证码错误';
                return false;
            }
        }

        $map['username'] = $username;
        $userInfo = $this->where($map)->find();
        if (!$userInfo) {
            $this->error = '帐号不存在';
            return false;
        }
        if (user_md5($password) !== $userInfo['password']) {
            $this->error = '密码错误'.user_md5($password);
            return false;
        }
        if ($userInfo['status'] === 0) {
            $this->error = '帐号已被禁用';
            return false;
        }
        // 获取菜单和权限
        $dataList = $this->getMenuAndRule($userInfo['id']);

        if (!$dataList['menusList']) {
            $this->error = '没有权限';
            return false;
        }

        if ($isRemember || $type) {
            $secret['username'] = $username;
            $secret['password'] = $password;
            $data['rememberKey'] = encrypt($secret);
        }

        // 保存缓存
        $info['userInfo'] = $userInfo;
        $info['sessionId'] = uniqid();
        $authKey = user_md5($userInfo['username'].$userInfo['password'].$info['sessionId']);
        $info['_AUTH_LIST_'] = $dataList['rulesList'];
        $info['authKey'] = $authKey;
        cache('Auth_'.$authKey, null);
        cache('Auth_'.$authKey, $info, config('LOGIN_SESSION_VALID'));
        // 返回信息
        $data['authKey']		= $authKey;
        $data['sessionId']		= $info['sessionId'];
        $data['userInfo']		= $userInfo;
        $data['authList']		= $dataList['rulesList'];
        $data['menusList']		= $dataList['menusList'];
        return $data;
    }

    /**
     * 修改密码
     * @param  array   $param  [description]
     */
    public function setInfo($auth_key, $old_pwd, $new_pwd)
    {
        $cache = cache('Auth_'.$auth_key);
        if (!$cache) {
            $this->error = '请先进行登录';
            return false;
        }
        if (!$old_pwd) {
            $this->error = '请输入旧密码';
            return false;
        }
        if (!$new_pwd) {
            $this->error = '请输入新密码';
            return false;
        }
        if ($new_pwd == $old_pwd) {
            $this->error = '新旧密码不能一致';
            return false;
        }

        $userInfo = $cache['userInfo'];
        $password = $this->where('id', $userInfo['id'])->value('password');
        if (user_md5($old_pwd) != $password) {
            $this->error = '原密码错误';
            return false;
        }
        if (user_md5($new_pwd) == $password) {
            $this->error = '密码没改变';
            return false;
        }
        if ($this->where('id', $userInfo['id'])->setField('password', user_md5($new_pwd))) {
            $userInfo = $this->where('id', $userInfo['id'])->find();
            // 重新设置缓存
            $cache['userInfo'] = $userInfo;
            $cache['authKey'] = user_md5($userInfo['username'].$userInfo['password'].uniqid());
            cache('Auth_'.$auth_key, null);
            cache('Auth_'.$cache['authKey'], $cache, config('LOGIN_SESSION_VALID'));
            return $cache['authKey'];//把auth_key传回给前端
        }

        $this->error = '修改失败';
        return false;
    }

    /**
     * 获取菜单和权限
     * @param  array   $param  [description]
     */
    protected function getMenuAndRule($u_id)
    {
        $rules = [];
        if ($u_id === 1) {
            $map['status'] = 1;
            $menusList = Db::name('admin_menu')->where($map)->order('sort asc')->select();
        } else {
            $groups = $this->get($u_id)->groups;
            $ruleIds = [];
            foreach($groups as $k => $v) {
                $ruleIds = array_unique(array_merge($ruleIds, explode(',', $v['rules'])));
            }

            $ruleMap['id'] = array('in', $ruleIds);
            $ruleMap['status'] = 1;
            // 重新设置ruleIds，除去部分已删除或禁用的权限。
            $rules =Db::name('admin_rule')->where($ruleMap)->select();
            foreach ($rules as $k => $v) {
                $ruleIds[] = $v['id'];
                $rules[$k]['name'] = strtolower($v['name']);
            }
            empty($ruleIds)&&$ruleIds = '';
            $menuMap['status'] = 1;
            $menuMap['rule_id'] = array('in',$ruleIds);
            $menusList = Db::name('admin_menu')->where($menuMap)->order('sort asc')->select();
        }
        if (!$menusList) {
            return null;
        }
        //处理菜单成树状
        $ret['menusList'] = Tree::unlimitForLayer($menusList);

        // 处理规则成树状
        $ret['rulesList'] = Tree::unlimitForLayer($rules);

        return $ret;
    }
}
