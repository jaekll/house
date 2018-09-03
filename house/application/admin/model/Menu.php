<?php 
namespace app\admin\model;

use think\Db;
use app\admin\model\Common;
use app\common\lib\Tree;

class Menu extends Common 
{

    protected $name = 'admin_menu';
    /**
     * [getDataList 获取列表]
     * @return    [array]                         
     */
    public function getDataList()
    {   
         $data = $this->where('status',1)->field('id,title,pid')->select();
         $data_tree = Tree::unlimitForLayer($data);
         return $data_tree;
    }

    /**
     * [getDataById 根据主键获取详情]
     * @param     string                   $id [主键]
     * @return    [array]                       
     */
    public function getDataById($id = '')
    {
        $data = $this
                ->alias('menu')
                ->where('menu.id', $id)
                ->join('__ADMIN_RULE__ rule', 'menu.rule_id=rule.id', 'LEFT')
                ->field('menu.*, rule.title as rule_name')
                ->find();
        if (!$data) {
            $this->error = '暂无此数据';
            return false;
        }
        return $data;
    }


    /**
     * 整理菜单树形结构
     * @param  array   $param  [description]
     */
    protected function getMenuTree()
    {   
        $userInfo = $GLOBALS['userInfo'];
        if (!$userInfo) {
            return [];
        }
        
        $u_id = $userInfo['u_id'];
        if ($u_id === 1) {
            $map['status'] = 1;
            $menusList = Db::name('admin_menu')->where($map)->order('sort asc')->select();
        } else {
            $groups = model('User')->get($u_id)->groups;
            
            $ruleIds = [];
            foreach($groups as $k => $v) {
                $ruleIds = array_unique(array_merge($ruleIds, explode(',', $v['rules'])));
            }
            $ruleMap['id'] = array('in', $ruleIds);
            $ruleMap['status'] = 1;
            // 重新设置ruleIds，除去部分已删除或禁用的权限。
            $ruleIds =  Db::name('admin_rule')->where($ruleMap)->column('id');
            empty($ruleIds)&&$ruleIds = '';
            $menuMap['status'] = 1;
            $menuMap['rule_id'] = array('in',$ruleIds);
            $menusList =  Db::name('admin_menu')->where($menuMap)->order('sort asc')->select();
        }
        if (!$menusList) {
            return [];
        }
        
    }
?>