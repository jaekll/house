<?php
namespace app\admin\model;


use app\common\lib\Tree;

class Rule extends Base
{

    protected $name = 'admin_rule';
    /**
     * [getDataList 获取列表]
     * @param     string                   $type [是否为树状结构]
     * @return    [array]
     */
    public function getDataList($type = '')
    {
        $data = $this->select();
        $data = Tree::unlimitForLayer($data);
        return $data;
    }

}