<?php

namespace app\admin\controller;

use app\admin\model\AdminRole;
use app\admin\model\Node;
use app\admin\model\NodeRole;
use think\Controller;
use think\facade\Request;

class Role extends Controller
{
    public function index()
    {
        $role=\app\admin\model\Role::all();
        return view("",["roles"=>$role]);

    }
    public function check_role_name(){
        $node_name=request()->get("node_name","");
        $node=new \app\admin\model\Role();
        $data=$node->getRoleId($node_name);
        if($data){
            echo json_encode(["status"=>1,"msg"=>"角色已存在"]);
        }else{
            echo json_encode(["status"=>0,"msg"=>"OK"]);
        }
    }
    public function add()
    {
        if(request()->isGet()){
            $node=new Node();
            $nodes = $node->getNode();
            return view("", ["nodes" => $nodes]);
        }
        if(request()->isPost()){
            //接值
            $roleModel=new \app\admin\model\Role();
            $roleModel->role_name=request()->post("role_name");
            $roleModel->role_desc=request()->post("role_desc");
            $roleModel->save();
            $node_id=Request::instance()->post()["node_id"];
            if($node_id){
                $rodeNode=$roleModel->node()->saveAll($node_id);
                if($rodeNode){
                    $this->success("添加角色成功","Role/index");
                }else{
                    $this->error("添加角色失败");
                }

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
