<?php
/**
 * Created by PhpStorm.
 * User: 86152
 * Date: 2019/10/13
 * Time: 21:00
 */
namespace app\admin\controller;
use think\Db;
use think\facade\Request;

class Brand extends Common
{
    public function add_brand()
    {
        if (request()->isGet()) {
            return view();
        }
        if(request()->isPost()){
            //接值
            $data["brand_name"] = request()->post("brand_name", "");
            $data["brand_url"] = request()->post("brand_url", "");
            $data["brand_des"]=request()->post("brand_des","");
            $data["brand_order"] = request()->post("brand_order", "");
            //上传图片至七牛云

            //处理上传图片
            $file = Request::file('brand_logo');
            $info=$file->validate(['size'=>2048000,'ext'=>'gif,png,jpg'])->move("uploads/brand");
            if($info) {
                $data['brand_logo'] = request()->domain() . "/uploads/brand/" . str_replace('\\', "/", $info->getSaveName());
            }
            //入库
            $brand=Db::name("brand")->insert($data);
            if($brand){
                $this->success("添加成功","Brand/show_brand");
            }else{
                $this->error("添加失败");
            }
        }
    }
    public function show_brand(){
        $brand=Db::name("brand")->select();
        return view("",["brand"=>$brand]);
    }
    public function brandDel(){
        $brand_id=request::get("brand_id","");
        $brandDelete=Db::name("brand")->delete($brand_id);
        if($brandDelete){
            echo $brandDelete(["status"=>1,"msg"=>"删除分类成功"]);
        }else{
            echo json_encode(["status"=>0,"msg"=>"删除分类失败"]);
        }

    }
}