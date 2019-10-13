<?php
/**
 * Created by PhpStorm.
 * User: 86152
 * Date: 2019/10/12
 * Time: 14:01
 */
namespace app\admin\controller;
use think\captcha\Captcha;
use think\Controller;
use think\Cookie;
use think\Db;
use think\facade\Request;
use think\facade\Session;

class Login extends Controller{
    public function login()
    {
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()) {
//            //判断验证码
//            $code=request::post("code","");
//            $captcha=new Captcha();
//            if( !$captcha->check($code)){
//                $this->error("验证码错误");
//            }
            //接值
            $admin_name=request::post("admin_user","");
            $admin_pwd=request::post("admin_pwd","");
            $save=request::post("save","");
            $admin=Db::name("admin")
                ->where("admin_user",$admin_name)
                ->where("admin_pwd",$admin_pwd)
                ->find();
            if($admin){
                if($save==1){
                    cookie('admin',$admin,3600*7);
                }
                Session::set("admin",$admin);
                $this->success("登陆成功","index/index");
                Session::clear('admin');
            }else{
                $this->error("登陆失败");
            }
        }
    }
    public function code()
    {
        $captcha = new Captcha();
        return $captcha->entry();
    }

}