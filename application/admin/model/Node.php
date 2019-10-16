<?php

namespace app\admin\model;

use think\Model;

class Node extends Model
{
    protected $pk = 'node_id';
    public function getNode(){
        $allNode =Node::all();
        return $this->getSonNode($allNode);
    }
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
    public function getFarNode(){
        $node=Node::where("node_pid",0)->select();
        return $node;
    }
    public function getCheckNode($data){
        $node=Node::where("node_name",$data)->find();
        return $node;
    }
}
