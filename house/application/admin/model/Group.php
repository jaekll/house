<?php
/*
*权限分组
**/
namespace app\admin\model;

use app\common\lib\Tree;

class Group extends Base{
    
    protected $name = 'admin_group';


    /**
     * [getList 获取列表]
     * @return    [array]                         
     */
    public function getList()
    {
         $data = $this->where('status',1)->field('id,title,pid')->select();
         $data_tree = Tree::unlimitForLayer($data);
         return $data_tree;
    }

    public function getDataById($id){
        return $this->where('id',$id)->find();    
    }
}