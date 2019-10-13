<?php
/**
 * Created by PhpStorm.
 * User: 86152
 * Date: 2019/10/12
 * Time: 16:03
 */
namespace app\admin\model;
use think\Db;
use think\Model;
class CateAll extends Model
{
    public function getCateAll(){
        $cates=Db::name("cate")->select();
        return $this->getCateByRecursion($cates);
    }
    public function getCateByRecursion($cate,$pid=0,$level=0){
        $orderCate=[];
        foreach($cate as $key => $value) {
            if($value["cate_pid"]==$pid){
                $value["level"]=$level;
                $orderCate[]=$value;
                $orderCate=array_merge($orderCate,$this->getCateByRecursion($cate,$value["cate_id"],$level+1));
            }
        }
        return $orderCate;
    }
}