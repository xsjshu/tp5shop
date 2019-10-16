<?php
/**
 * Created by PhpStorm.
 * User: 86152
 * Date: 2019/10/14
 * Time: 14:44
 */
namespace app\admin\controller;
use app\admin\Service\AdminService;
use think\Controller;
use think\facade\Cookie;
use think\facade\Session;

class Common extends Controller{

    public function __construct(){
        parent::__construct();
        $cookie=Cookie::get("admin");
        $session=Session::get("admin");
        if($cookie&&!$session) {
            Session::set("admin",$cookie);
        }
        if(!Session::get("admin")){
            //$this->error("非法登录");
        }
        //检查权限
        if(!$this->checkNode()){
                echo "你没有权限操作";
               //$this->success("你没有权限操作",'Index/index');
        }


    }
    //检查权限的方法
    public function checkNode(){
        $getAdmin=Session::get("admin");
        //判断是否是超级管理员
        if(in_array($getAdmin["admin_user"],config("web.super_admin"))){
             return true;
        }
        //如果不是超级管理员，检查普通管理员拥有的权限
        //获取要访问的控制器和方法
        $access=ucfirst(strtolower(request()->controller()))."/".strtolower(request()->action());
        //公共模板都可以访问
        if(in_array($access,config("web.no_check_action"))){
             return true;
        }
        //获取当前用户的所拥有的权限
        $adminService=new AdminService();
        $data=$adminService->getNodeByAdminId($getAdmin["admin_id"]);
//        dump($access);
//        dump($data);
        if(in_array($access,$data)){
            return true;
        }else{
            return false;
        }


    }
}