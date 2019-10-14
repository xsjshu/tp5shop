<?php
/**
 * Created by PhpStorm.
 * User: 86152
 * Date: 2019/10/14
 * Time: 14:44
 */
namespace app\admin\controller;
use think\Controller;
use think\facade\Cookie;
use think\facade\Session;

class Common extends Controller{

    public function __construct(){

        $cookie=Cookie::get("admin");
        $session=Session::get("admin");
        if($cookie&&!$session) {
            Session::set("admin",$cookie);
        }

    }
}