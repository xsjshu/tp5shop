<?php
/**
 * Created by PhpStorm.
 * User: 86152
 * Date: 2019/10/12
 * Time: 15:04
 */
namespace app\admin\controller;
use app\admin\model\Cate;
use think\Controller;
use think\Db;
use think\facade\Cookie;
use think\facade\Session;
use think\Model;

class Index extends Controller
{
    public function index(){
        $cookie=Cookie::get("admin");
        $session=Session::get("admin");
        if($cookie&&!$session) {
            Session::set("admin",$cookie);
        }
        return view();
    }
}