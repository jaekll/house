<?php  
namespace app\admin\model;

/**
 * 模型基础类
 */

use \think\Model;
use \think\Log;

class Base extends Model
{
    protected $error = '';//数据操作错误
    
    public function getDataById($id)
    {
        $data = $this->get($id);
        if (!$data) {
            $this->error = '暂无数据';
            return false;
        }

        return $data;
    }

    public function getError(){
        return $this->error;
    }
     /**
     * [createData 新建]
     * @param     array                    $param [description]
     * @return    [array]                         [description]
     */
    public function createData($param)
    {
        
        // 验证
        $validate = validate($this->name);
        if (!$validate->check($param)) {
            $this->error = $validate->getError();
            return false;
        }
        try {
            $this->data($param)->allowField(true)->save();
            return true;
        } catch(\Exception $e) {
            Log::record($e->getMessage(),Log::ERROR);
            $this->error = '添加失败';
            return false;
        }
    }

    /**
     * [updateDataById 编辑]
     * @param     [type]                   $param [description]
     * @param     [type]                   $id    [description]
     * @return    [type]                          [description]
     */
    public function updateDataById($param, $id)
    {
        $checkData = $this->get($id);
        if (!$checkData) {
            $this->error = '暂无此数据';
            return false;
        }

        // 验证
        $validate = validate($this->name);
        if (!$validate->check($param)) {
            $this->error = $validate->getError();
            return false;
        }

        try {
            $this->allowField(true)->save($param, [$this->getPk() => $id]);
            return true;
        } catch(\Exception $e) {
            Log::record($e->getMessage(),Log::ERROR);
            $this->error = '编辑失败';
            return false;
        }
    }

    /**
     * [delDataById 根据id删除数据]
     * @param     string                   $id     [主键]
     * @param     boolean                  $delSon [是否删除子孙数据]
     * @return    [type]                           [description]
     */
    public function delDataById($id = '', $delSon = false)
    {

        $this->startTrans();
        try {
            $this->where($this->getPk(), $id)->delete();
            if ($delSon && is_numeric($id)) {
                // 删除子孙
                $childIds = $this->getAllChild($id);
                if($childIds){
                    $this->where($this->getPk(), 'in', $childIds)->delete();
                }
            }
            $this->commit();
            return true;
        } catch(\Exception $e) {
            Log::record($e->getMessage(),Log::ERROR);
            $this->error = '删除失败';
            $this->rollback();
            return false;
        }       
    }

    /**
     * [delDatas 批量删除数据]
     * @param     array                   $ids    [主键数组]
     * @param     boolean                 $delSon [是否删除子孙数据]
     * @return    [type]                          [description]
     */
    public function delDatas($ids = [], $delSon = false)
    {
        if (empty($ids)) {
            $this->error = '删除失败';
            return false;
        }
        
        // 查找所有子元素
        if ($delSon) {
            foreach ($ids as $k => $v) {
                if (!is_numeric($v)) continue;
                $childIds = $this->getAllChild($v);
                $ids = array_merge($ids, $childIds);
            }
            $ids = array_unique($ids);
        }

        try {
            $this->where($this->getPk(), 'in', $ids)->delete();
            return true;
        } catch (\Exception $e) {
            Log::record($e->getMessage(),Log::ERROR);
            $this->error = '操作失败';
            return false;
        }       

    }

    /**
     * [enableDatas 批量启用、禁用]
     * @param     string                   $ids    [主键数组]
     * @param     integer                  $status [状态1启用0禁用]
     * @param     [boolean]                $delSon [是否删除子孙数组]
     * @return    [type]                           [description]
     */
    public function enableDatas($ids = [], $status = 1, $delSon = false)
    {
        if (empty($ids)) {
            $this->error = '删除失败';
            return false;
        }

        // 查找所有子元素
        if ($delSon && $status === '0') {
            foreach ($ids as $k => $v) {
                $childIds = $this->getAllChild($v);
                $ids = array_merge($ids, $childIds);
            }
            $ids = array_unique($ids);
        }
        try {
            $this->where($this->getPk(),'in',$ids)->setField('status', $status);
            return true;
        } catch (\Exception $e) {
            Log::record($e->getMessage(),Log::ERROR);
            $this->error = '操作失败';
            return false;
        }
    }

    /**
     * 获取所有子孙
     */
    public function getAllChild($id, &$data = [])
    {
        $map['pid'] = $id;
        $childIds = $this->where($map)->column($this->getPk());
        if (!empty($childIds)) {
            foreach ($childIds as $v) {
                $data[] = $v;
                $this->getAllChild($v, $data);
            }
        }
        return $data;
    }       
}
