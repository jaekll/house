<?php 
namespace app\admin\controller;

/**
 * 权限分组
 */
use \think\Request;
use app\admin\model\Group;

class Groups extends Base
{
    
    public function index(Request $request)
    {
       $model = new Group();
       $data = $model->getList();
       return $this->ok($data);
    }

    public function read(){
        $model = new Group();
        $data = $model->getDataById($this->param['id']);
        if(!$data){
            return $this->err($model->getError());        
        }
    }

    public function save(Request $request){
        $model = new Group();
        if($model->createData($request->param())){
             $this->ok('添加成功');   
        }

        return $this->err('添加失败');
    }

    public function edit(){
        $model = new Group();
        if($model->updateDataById($this->param,$this->param['id'])){
               return $this->ok('更新成功') ;
        }
        return $this->err('更新失败');
    }

    public function delete(){
        $model = new Group();
        if($model->delDataById($this->param['id'])){
           $this->ok('更新成功');     
        }
        $this->err('更新失败')；
    }
}
?>