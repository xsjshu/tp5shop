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

class AdminNode extends Model{
    //权限的展示
    public function getNode(){
        $allNode=Db::name("node")->select();
        return $this->getSonNode($allNode);
    }
    //添加权限
    public function addNode($data){
        $addNode=Db::name("node")->insert($data);
        return $addNode;
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
    //获取所有管理员
    public function getAdmin(){
        $admin=Db::name("admin")->select();
        return $admin;
    }
    //获取所有角色
    public function getRole(){
        $role=Db::name("role")->select();
        return $role;
    }
    //添加角色
    public function addRole($data){
        $addRole=Db::name("role")->insert($data);
        return $addRole;
    }
    //获取角色id
    public function getNode_id($role_name){
        $role_id=Db::name("role")->where("role_name",$role_name)->find();
        return $role_id;
    }
    //添加角色权限表
    public function addRoleNode($data){
        $addRoleNode=Db::name("role_node")->insert($data);
        return $addRoleNode;
    }
    //获得所有父级角色
    public function getFarRole(){
        $roleSon=Db::name("node")->where('node_pid',0)->select();
        return $roleSon;
    }
    //添加管理员
    public function addAdmin($data){
        $addAdmin=Db::name("admin")->insert($data);
        return $addAdmin;
    }
    //获取管理员id
    public function getAdmin_id($admin_user){
        $admin_id=Db::name("admin")->where("admin_user",$admin_user)->find();
        return $admin_id;
    }
    //添加管理员角色表
    public function addAdminRole($data){
        $adminRole=Db::name("admin_role")->insert($data);
        return $adminRole;
    }


}