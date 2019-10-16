<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Node extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //权限的展示
        $node=new \app\admin\model\Node();
        $nodes=$node->getNode();
        return view("",["nodes"=>$nodes]);
    }
    //检查权限名称是否存在
    public function check_node_name(){
        $node_name=request()->get("node_name","");
        $node=new \app\admin\model\Node();
        $data=$node->getCheckNode($node_name);
        if($data){
            echo json_encode(["status"=>1,"msg"=>"权限已存在"]);
        }else{
            echo json_encode(["status"=>0,"msg"=>"OK"]);
        }
    }
    //权限的添加
    public function add(){
        if(request()->isGet()){
            $node=new \app\admin\model\Node();
            $nodes=$node->getFarNode();
            return view("",["node"=>$nodes]);
        }
        if(request()->isPost()){
            //接值
            $data["node_name"]= request()->post("node_name","");
            $data["node_pid"]= request()->post("node_pid","");
            $data["node_ismenu"]=request()->post("node_ismenu","");
            $data["node_controller"]=request()->post("node_controller","");
            $data["node_action"]=request()->post("node_action","");
            $data["node_url"]=request()->post("node_url","");
            //入库
            $node=new \app\admin\model\Node();
            $addNode= $node->save($data);
            if($addNode){
                $this->success("添加权限成功","Node/index");
            }else{
                $this->error("添加权限失败");
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
