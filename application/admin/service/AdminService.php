<?php

namespace app\admin\Service;

use app\admin\model\AdminRole;
use app\admin\model\Role;
use think\facade\Session;
use think\Model;

class AdminService extends Model
{
    //
    public function getNodeByAdminId($admin_id)
    {
        //根据admin_id通知中间表拿到角色id
        $adminRole=new AdminRole();
        $role_id=$adminRole->where("admin_id",$admin_id)->column("role_id");
        //通过rode_id拿到所有的角色
        $role=new Role();
        $role=$role->all($role_id);
        $myNode=[];
        foreach($role as $key=>$value){
            $myNode=array_merge($myNode,$value->node->toArray());
        }
        $myAccess=[];
        foreach($myNode as $k=>$v){
            array_push($myAccess,ucfirst(strtolower($v["node_controller"]))."/".strtolower($v["node_action"]));
        }
        //去重
        $myAccess=array_unique($myAccess);
        return $myAccess;
    }
    public function getMenus()
    {
       //去用户Session里面的信息
        $admin_user=Session::get("admin")["admin_user"];
        if(in_array($admin_user,config("web.super_admin"))){

        }
    }

}
