<?php
namespace app\admin\controller;

use think\facade\Request;

class Menus extends Base
{
    
    public function index()
    {   
        $menuModel = model('Menu');
        $param = Request::param();
        $data = $menuModel->getDataList();
        return $this->ok($data);
    }

    public function read()
    {   
        $menuModel = model('Menu');
        if (!$menuModel->getDataById($this->param['id'])) {
            return $this->err($menuModel->getError());
        } 
        return $this->ok();
    }

    public function save()
    {
        $menuModel = model('Menu');
        $data = $menuModel->createData($this->param);
        if (!$data) {
            return $this->err($menuModel->getError());
        } 
        return $this->ok();
    }

    public function update()
    {
        $menuModel = model('Menu');
        $data = $menuModel->updateDataById($this->param, $this->param['id']);
        if (!$data) {
             return $this->err($menuModel->getError());
        } 
        return $this->ok();
    }

    public function delete()
    {
        $menuModel = model('Menu');
        $param = $this->param;
        $data = $menuModel->delDataById($param['id'], true);       
        if (!$data) {
            return $this->err($menuModel->getError());
        } 
        return $this->ok();
    }

    public function deletes()
    {
        $menuModel = model('Menu');
        $param = $this->param;
        $data = $menuModel->delDatas($param['ids'], true);  
        if (!$data) {
            return $this->err($menuModel->getError());
        } 
        return $this->ok();
    }

    public function enables()
    {
        $menuModel = model('Menu');
        $param = $this->param;
        $data = $menuModel->enableDatas($param['ids'], $param['status'], true);  
        if (!$data) {
            return $this->err($menuModel->getError());
        } 
       return $this->ok();
    }
}