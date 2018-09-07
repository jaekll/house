<?php
namespace app\admin\model;


use app\common\lib\Tree;

class Rule extends Base
{

    protected $name = 'admin_rule';

    public function getDataList($type = '')
    {
        $data = $this->select();
        $data = Tree::unlimitForLevel($data);
        return $data;
    }

}