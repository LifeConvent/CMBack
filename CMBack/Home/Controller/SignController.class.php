<?php
/**
 * Created by PhpStorm.
 * User: lawrance
 * Date: 2017/4/20
 * Time: 上午11:40
 */

namespace Home\Controller;


use Think\Controller;

class SignController extends Controller
{
    public function signIn()
    {
        $account = I('post.account');
        $pass = I('post.pass');
        if($account==null||$pass==null){
            $result['status'] = "error";
            $result['message'] = "POST_NULL";
            exit(json_encode($result));
        }
        $user = M('user');
        $username['username'] = "$account";
        $res = $user->where($username)->select();
        if ($res) {
            if ($res[0]['password'] == $pass) {
                $result['status'] = "success";
                $str = $account.'-'.$pass.'-'.time();
                $method = new MethodController();
                $token = $method->encode($str);
                $result['token'] = $token;
            } else {
                $result['status'] = "error";
                $result['message'] = "ACCOUNT_PASS_WRONG";
            }
            exit(json_encode($result));
        } else {
            $result['status'] = "error";
            $result['message'] = "ACCOUNT_NOT_EXIST";
            exit(json_encode($result));
        }
    }
}