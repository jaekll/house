<?php
 namespace app\admin\controller;

class Rules extends Base
{

    public function index()
    {   
        $ruleModel = model('Rule');
        $type = !empty($this->param['type'])?$this->param'type']: '';
        $data = $ruleModel->getDataList($type);
        return $this->ok($data);
    }

    public function read()
    {   
        $ruleModel = model('Rule');
        $data = $ruleModel->getDataById($this->param['id']);
        if (!$data) {
            return $this->err($ruleModel->getError());
        } 
        return $this->ok($data);
    }

    public function save()
    {
        $ruleModel = model('Rule');
         
        $data = $ruleModel->createData($this->param);
        if (!$data) {
           return $this->err($ruleModel->getError());
        } 
         return $this->ok([],'添加成功');
    }

    public function update()
    {
        $ruleModel = model('Rule');
        
        $data = $ruleModel->updateDataById($this->param, $this->param['id']);
        if (!$data) {
            return $this->err($ruleModel->getError());
        } 
         return $this->ok([],'编辑成功');
    }

    public function delete()
    {
        $ruleModel = model('Rule');
         
        $data = $ruleModel->delDataById($this->param['id'], true);       
        if (!$data) {
            return $this->err($ruleModel->getError());
        } 
         return $this->ok([],'删除成功');
    }

    public function deletes()
    {
        $ruleModel = model('Rule');
        $data = $ruleModel->delDatas($this->param['ids'], true);  
        if (!$data) {
            return $this->err($ruleModel->getError());
        } 
        return $this->ok([],'删除成功');
    }

    public function enables()
    {
        $ruleModel = model('Rule');
        $data = $ruleModel->enableDatas($this->param['ids'], $this->param['status'], true);  
        if (!$data) {
           return $this->err($ruleModel->getError());
        } 
        return $this->ok([],'操作成功');   
    }
}
 