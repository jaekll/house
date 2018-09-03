<?php
namespace app\admin\controller;

class Users extends ApiCommon
{

    public function index()
    {   
        $userModel = model('User');
        
        $keywords = !empty($this->param['keywords']) ? $this->param['keywords']: '';
        $page = !empty($this->param['page']) ? $this->param['page']: '';
        $limit = !empty($this->param['limit']) ? $this->param['limit']: '';    
        $data = $userModel->getDataList($keywords, $page, $limit);
        return $this->ok($data);
    }

    public function read()
    {   
        $userModel = model('User');
        
        $data = $userModel->getDataById($this->param['id']);
        if (!$data) {
            $this->err($userModel->getError());
        } 
        return $this->ok($data);
    }

    public function save()
    {
        $userModel = model('User');
        
        $data = $userModel->createData($this->param);
        if (!$data) {
            $this->err($userModel->getError());
        } 
        return $this->ok([],'添加成功');
    }

    public function update()
    {
        $userModel = model('User');
        
        $data = $userModel->updateDataById($this->param, $this->param['id']);
        if (!$data) {
            $this->err($userModel->getError());
        } 
        return $this->ok([],'编辑成功');
    }

    public function delete()
    {
        $userModel = model('User');
        
        $data = $userModel->delDataById($this->param['id']);       
        if (!$data) {
            $this->err($userModel->getError());
        } 
        return $this->ok([],'删除成功');    
    }

    public function deletes()
    {
        $userModel = model('User');
        
        $data = $userModel->delDatas($this->param['ids']);  
        if (!$data) {
            $this->err($userModel->getError());
        } 
        return $this->ok([],'删除成功');
    }

    public function enables()
    {
        $userModel = model('User');
        
        $data = $userModel->enableDatas($this->param['ids'], $this->param['status']);  
        if (!$data) {
            $this->err($userModel->getError());
        } 
        return $this->ok([],'操作成功');         
    }