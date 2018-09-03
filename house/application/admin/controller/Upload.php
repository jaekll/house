<?php
use think\Request;
use think\Controller;

class Upload extends Base
{   
    public function index()
    {   

        $file = request()->file('file');
        if (!$file) {
            return $this->err('未上传文件');
        }
        
        $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . DS . 'uploads');
        if ($info) {
            return $this->ok( 'uploads'. DS .$info->getSaveName());
        }
        
        return $this->err($file->getError());
    }
}
 