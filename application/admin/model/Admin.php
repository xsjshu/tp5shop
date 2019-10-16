<?php
/**
 * Created by PhpStorm.
 * User: 86152
 * Date: 2019/10/14
 * Time: 16:15
 */
namespace app\admin\model;
use think\Db;
use think\Model;

class Admin extends Model{
    //权限的展示
    protected $pk="admin_id";
    public function role(){
        return $this->belongsToMany("Role","admin_role","role_id","admin_id");
    }
    public function getNode(){
        $allNode= Admin::select();
        return $this->getSonNode($allNode);
    }
    //获取所有权限
    public function getSonNode($node,$pid=0,$level=0){
        $arr=array();
        foreach($node as $k => $v){
            if($v['node_pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                $arr=array_merge($arr,$this->getSonNode($node,$v["node_id"],$level+1));
            }

        }
        return $arr;
    }
    //获取管理员id
    public function getAdminId($admin_user){
        $admin_id=Admin::where("admin_user",$admin_user)->find();
        return $admin_id;
    }


}