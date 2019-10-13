<?php
/**
 * Created by PhpStorm.
 * User: 86152
 * Date: 2019/10/13
 * Time: 15:45
 */
namespace app\admin\controller;
use app\admin\model\CateAll;
use think\Controller;
use think\Db;
use think\facade\Request;
class Goods extends Controller{
    public function goods(){
        $cate=new CateAll();
        $cates=$cate->getCateAll();
        $goods=Db::name("goods")->select();
        return view("",["cates"=>$cates,"goods"=>$goods]);

    }
    public function add_goods(){
        if(request()->isGet()){
            //调用模型层方法取得所有的分类
            $cate=new CateAll();
            $cates=$cate->getCateAll();
            return view("",["cates"=>$cates]);
        }
        if(request()->isPost()){
            //接值入库
            $data["goods_name"]=request::post("goods_name","");
            $data["cate_id"]=request::post("cate_pid","");
            $data["goods_price"]=request::post("goods_price","");
            $data["goods_content"]=request::post("goods_content","");
            $data["keywords"]=request::post("keywords","");
            $data["goods_st_content"]=request::post("goods_st_content","");
            $data["goods_add_time"]=time();
            $file = Request::file('goods_images');
            $info=$file->validate(['size'=>2048000,'ext'=>'gif,png,jpg'])->move("uploads/brand");
            if($info) {
                $data['goods_images'] = request()->domain() . "/uploads/goods/" . str_replace('\\', "/", $info->getSaveName());
            }
            $addGoods=Db::name('goods')->insert($data);
            if($addGoods){
                $this->success("添加成功", "Goods/goods");
            }else{
                $this->error("添加失败");
            }
        }
    }
}