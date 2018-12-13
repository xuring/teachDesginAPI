<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Paginator;
use think\Session;

// --- START 添加如下一行 ---
// header('Access-Control-Allow-Origin: http://127.0.0.1:8080');
// 也可以添加所有的请求为 允许，当然不推荐这样做了、
// header('Access-Control-Allow-Origin: *');
// --- END ---


class Login extends controller {
   public function getlogin(){
      // session_start();
    	$user=input('user');
    	$password=input('password');
      // return $password;
    	if($user!=''&&$password!=''){
        $password=md5($password);
      	$result=Db::query("SELECT * FROM `user_table` WHERE (name='$user' or email='$user')  And password='$password'");
      	// return $result;
    		if(!$result){
    			   returnApiError("456",'登录失败');   	
     		}else{
            Session::set('user',$user);
            Session::set('word',$password);
            $session= session_id();//直接获取服务器的session值，PHPSESSID是服务器发到前端在传过来的值
            Db::table('user_table')->where('email',$user)->whereOr('name',$user)->update(['condition'=>'1','session'=>$session]);
            $data['user']=Session::get('user');
            returnSuccessLogin("123",$data);
   		  }
   	  }
   }
   public function loginOut(){
      $user=Session::get('user');
      $password=Session::get('word');
      if($user!=null&&$password!=null){
      //删除过期session
        $info=Db::table('user_table')->where('name',$user)->update(['condition'=>'0','session'=>'']);
        if($info){
          Session::clear();
          Session::destroy();
          returnApiSuccess("123",$info);
        }else{
          returnApiError($info);
        }
      }else{
        returnApiError('请先登录！');
      }
    }

  public function signUp(){
    $name=input('name');
    $password=input('password');
    $email=input('email');
    if($name!=''&&$password!=''&&$email!=''){
      $password=md5($password); 
      $personName=Db::query("SELECT * FROM `user_table` where name='$name'");
      if($personName==null){
        $personEmail=Db::query("SELECT * FROM `user_table` where email='$email'");
        if($personEmail==null){
             $data = ['name' => $name, 'password' => $password, 'email' => $email];
             Db::name('user_table')->data($data)->insert();
             returnApiSuccess("123","注册成功");
        }else{
          returnApiError('邮箱已注册');
        }
      }else{
        returnApiError('用户名已存在');
      }
    }
  }
   
  //修改密码
  public function editPassword(){
    $newPassword=input('newPassword');
    $oldPassword=input('oldPassword');
    $user=input('user');
    $newPassword=md5($newPassword);
    $oldPassword=md5($oldPassword);
    // return $oldPassword
    $person=Db::query("SELECT * FROM `user_table` where name='$user'");
    $password=$person[0]['password'];
    if($password==$oldPassword){
      $result=Db::table('user_table')->where('email',$user)->whereOr('name',$user)->update(['password'=>$newPassword]);  
      // return $result;
      if($result){
        returnSuccess('1');
      }else{
        returnApiError('0');
      }
    }else{
      returnApiError('原始密码不正确');
    }
    
  } 
  //重置密码
  public function resetPassword(){
     $user=input('user');
     $newPassword=md5('123456');
     $result=Db::table('user_table')->where('email',$user)->whereOr('name',$user)->update(['password'=>$newPassword]); 
     // var_dump($newPassword); 
       if(!$result){
        returnSuccess('1');
      }else{
        returnApiError('0');
      }
  }

  //删除Session时的判断
  public function delSession(){
    $user=Session::get('user');
    print_r(Session::get('user'));
    if(!$user){
      Db::table('user_tb')->where('USER',$user)->update(['CONDITION'=>'0']);
      returnApiSuccess("123",$user);
    }else{
       returnApiError('456');
    }
  }

  //在线状态更新
  public function judgeInStill(){
      $user=Session::get('user');
      $password=Session::get('word');
      $result=Db::query("SELECT * FROM `user_tb` WHERE USER='$user' And PASSWORD='$password'");
      $session=$_COOKIE['PHPSESSID'];
      if($result){
          if($session!=$result[0]['SESSION']){
            returnApiError('已在其他地方登陆');
          }
      }      
  }
}