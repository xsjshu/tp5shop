<?php
/**
 * Created by PhpStorm.
 * User: 86152
 * Date: 2019/10/14
 * Time: 15:07
 */
namespace app\admin\controller;
use app\admin\model\Role;
use think\facade\Request;

class Admin extends Common{
    public function index(){
        $admin=new \app\admin\model\Admin();
        $admin=$admin->select();
        return view("",["admin"=>$admin]);
    }
    public function check_admin_name(){
        $admin_user=request()->get("admin_user","");
        $admin_name=new \app\admin\model\Admin();
        $data=$admin_name->getAdminId($admin_user);
        if($data){
            echo json_encode(["status"=>1,"msg"=>"用户已存在"]);
        }else{
            echo json_encode(["status"=>0,"msg"=>"OK"]);
        }
    }
    public function add(){
        if(request()->isGet()){
            $role=new Role();
            $roles=$role->all();
            return view("",["roles"=>$roles]);
        }
        if(request()->isPost()){
              //接值
            $data["admin_email"]=request::post("admin_email","");
            $role_id=request::post("role_id","");
            $data["admin_user"]=request::post("admin_user","");
            $data["pwd_sult"]=substr(uniqid(),-4);
            $admin_pwd=request::post("admin_pwd","");
            $data["admin_pwd"]=md5(md5($admin_pwd).$data["pwd_sult"]);
            $data["add_time"]=time();
            //入库
            $addAdmin=new \app\admin\model\Admin();
            $addAdmin=$addAdmin->role()->saveAll($role_id);
            if($addAdmin){
                 $this->success("添加管理员成功","Admin/admin");
            }else{
                  $this->error("添加管理员失败");
            }
        }

    }
    public function update(){
        echo "我是修改";
    }
    public function delete(){
        echo "我是删除";
    }



}