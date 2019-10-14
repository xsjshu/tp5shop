<?php
/**
 * Created by PhpStorm.
 * User: 86152
 * Date: 2019/10/14
 * Time: 15:07
 */
namespace app\admin\controller;
use app\admin\model\AdminNode;
use think\facade\Request;

class Admin extends Common{
    public function admin(){
        $admin=new AdminNode();
        $admin=$admin->getAdmin();
        return view("",["admin"=>$admin]);
    }
    public function add_manager(){
        if(request()->isGet()){
            $role=new AdminNode();
            $roles=$role->getRole();
            return view("",["roles"=>$roles]);
        }
        if(request()->isPost()){
              //接值
            $data["admin_email"]=request::post("admin_email","");
            $data["role_id"]=request::post("role_id","");
            $data["admin_user"]=request::post("admin_user","");
            $data["pwd_sult"]=substr(uniqid(),-4);
            $admin_pwd=request::post("admin_pwd","");
            $data["admin_pwd"]=md5(md5($admin_pwd).$data["pwd_sult"]);
            $data["add_time"]=time();

            $addAdmin=new AdminNode();
            $addadmin=$addAdmin->addAdmin($data);
            if($addadmin){
                $admin=$addAdmin->getAdmin_id($data["admin_user"]);
                if($admin){
                    $adminRole=["admin_id"=>$admin["admin_id"],"role_id"=>$data["role_id"]];
                    $adminRole=$addAdmin->addAdminRole($adminRole);
                    if($adminRole){
                        $this->success("添加成功","Admin/admin");
                    }else{
                        $this->error("添加失败");
                    }
                }

            }
        }

    }
    public function role(){
        $role=new AdminNode();
        $roles=$role->getRole();
        return view("",["roles"=>$roles]);
    }
    public function add_role(){
        if(request()->isGet()){
            $node = new AdminNode();
            $nodes = $node->getNode();
            return view("", ["nodes" => $nodes]);
        }
        if(request()->isPost()){
            //接值
            $data["role_name"]=request::post("role_name","");
            $data["role_desc"]=request::post("role_desc","");
            $node_id=request::post("node_id","");
            $addAdmin=new AdminNode();
            $addRole=$addAdmin->addRole($data);
            if($addRole){
                $addAdmin=new AdminNode();
                $role=$addAdmin->getNode_id($data["role_name"]);
                $RoleNode=['node_id' => $node_id, 'role_id' => $role['role_id']];
                $addRoleNode=$addAdmin->addRoleNode($RoleNode);
                if($addRoleNode){
                    $this->success("添加成功","Admin/role");
                }else{
                    $this->error("添加失败");
                }

            }

        }
    }
    public function node(){
        $node=new AdminNode();
        $nodes=$node->getNode();
        return view("",["nodes"=>$nodes]);
    }
    public function add_node(){
        if(request()->isGet()){
            $role=new AdminNode();
            $roleFar=$role->getFarRole();
            return view("",["roles"=>$roleFar]);
        }
        if(request()->isPost()){
            //接值
            $data["node_name"]=request::post("node_name","");
            $data["node_pid"]=request::post("node_pid","");
            $data["node_ismenu"]=request::post("node_ismenu","");
            $addNode=new AdminNode();
            $addNode=$addNode->addNode($data);
            if($addNode){
                $this->success("添加权限成功","Admin/node");
            }else{
                $this->error("添加权限失败");
            }
        }


    }
}