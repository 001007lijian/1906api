<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;
use App\Model\UserModel;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $name = request()->input('name');
        $pwd = request()->input('pwd');

        if(empty($name) || empty($pwd)){
            return json_encode(['code'=>202,'msg'=>'参数不能为空，请您重新输入']);
        }

        $apiData = UserModel::where(['name'=>$name,'pwd'=>$pwd])->first();

        if(!$apiData){
            return json_encode(['code'=>203,'msg'=>'用户名或者密码不正确，请重新输入']);die;
        }else{
            $token = md5($apiData['id'].time());
            // 写入token
            $apiData->token=$token;
            // token有效时间
            $apiData->ex_time = time()+7200;
            $apiData->save();
        }

        if($apiData){
            return json_encode(['code'=>200,'msg'=>'登录成功']);
        }else{
            return json_encode(['code'=>201,'msg'=>'登录失败']);
        }
    }

    public  function reg(Request $request)
    {

    }

    public function doreg()
    {

    }

    public function logout()
    {

    }
}
