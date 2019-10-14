<?php
/**
 * Created by PhpStorm.
 * User: 86152
 * Date: 2019/10/13
 * Time: 13:39
 */
namespace app\admin\controller;
use app\admin\model\CateAll;
use think\Db;
use think\Model;
use think\facade\Request;
class Cate extends Common{
    public function product_category(){
        $cate=new CateAll();
        $cates=$cate->getCateAll();
        return view("",["cates"=>$cates]);
    }
    public function add_product_category(){
        if(request()->isGet()){
            //调用模型层方法取得所有的分类
            $cate=new CateAll();
            $cates=$cate->getCateAll();
            return view("",["cates"=>$cates]);
        }
        if(request()->isPost()){
            //接值
            $data["cate_name"]=request::post("cate_name","");
            $data["cate_pid"]=request::post("cate_pid","");
            $data["cate_an_name"]=request::post("cate_an_name","");
            $data["cate_keywolds"]=request::post("keywords","");
            $data["cate_order"]=request::post("cate_order","");
            $data["cate_content"]=request::post("cate_content","");
            $data["cate_add_time"]=time();
            //入库
            $addCate=Db::name('cate')->insert($data);
            if($addCate){
                $this->success("添加成功", "Cate/product_category");
            }else{
                $this->error("添加失败");
            }
        }
    }
    public function cateDelete(){
        $cate_id=request::get("cate_id","");
        $cateDelete=Db::name("cate")->delete($cate_id);
        if($cateDelete){
            echo json_encode(["status"=>1,"msg"=>"删除分类成功"]);
        }else{
            echo json_encode(["status"=>0,"msg"=>"删除分类失败"]);
        }

    }
}