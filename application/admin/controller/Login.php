<?php
/**
 * Created by PhpStorm.
 * User: 86152
 * Date: 2019/10/12
 * Time: 14:01
 */
namespace app\admin\controller;
use app\admin\model\Admin;
use think\captcha\Captcha;
use think\Controller;
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
            $admin_user = request::post("admin_user", "");
            $admin_pwd = request::post("admin_pwd", "");
            $save = request::post("save", "");
            $admin = new Admin();
            $admin = $admin->getAdminId($admin_user);
            if ($admin_pwd = md5(md5($admin_pwd) . $admin['pwd_sult'])) {
                $time = time();
                $admin->admin_login_time=$time;
                $admin->save();
                if ($save == 1) {
                    cookie('admin', $admin, 3600 * 7);
                }
                Session::set("admin", $admin);

                $this->success("登陆成功", "index/index");
                Session::clear('admin');
            } else {
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