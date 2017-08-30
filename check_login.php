<?php
session_start();
require_once('conn.php');
$action = $_POST['action'];
$res = array();

if($action == 'login'){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = sprintf('select userpwd from user where userId ="%s"', $username);
  if(!$q = mysql_query($sql)){
    $res['status'] = -1;
    $res['msg'] = 'MysqlError: '.mysql_error();
  }else{
    if(mysql_num_rows($q) == 0){
      $res['status'] = 1;
      $res['msg'] = '用户名不存在';
    }else{
      $real_pwd = mysql_fetch_row($q)[0];
      if($real_pwd != $password){
       $res['status'] = 2;
        $res['msg'] = '用户名与密码不匹配';
      }else{
        $res['status'] = 0;
        $_SESSION['user'] = $username;

        $res['msg'] = '登录成功';
      }
    }
  }
}elseif($action == 'logout'){
  if(isset($_SESSION['user'])){
     unset($_SESSION['user']);
     $res['status'] = 0;
     if(isset($_SESSION['picNum'])) unset($_SESSION['picNum']);
     if(isset($_SESSION['dir'])) unset($_SESSION['dir']);
     if(isset($_SESSION['dirName'])) unset($_SESSION['dirName']);
     if(isset($_SESSION['dirStatus'])) unset($_SESSION['dirStatus']);
  }else{
    $res['status'] = 1;
  }
}elseif($action == 'user'){
        /*完成清理数量*/
        $user = $_SESSION['user'];
        $sql = "select * from user_task where userId='$user' and status = 1 and task='clean'";
        $clean_num = mysql_num_rows(mysql_query($sql));
        // [>完成标记数量<]
        // $sql = "select * from user_task where userId=$username and status = 1 and task='mask'";
        // $mask_num = mysql_num_rows(mysql_query($sql));
        // $_SESSION['mask_num'] = $mask_num;

        // [>完成筛选数量<]
        // $sql = "select * from user_task where userId=$username and status = 1 and task='filter'";
        // $filter_num = mysql_num_rows(mysql_query($sql));
        // $_SESSION['filter_num'] = $filter_num;

        /*未完成任务*/
        $sql = "select * from user_task where userId='$user' and status = 0 and task='clean'";
        $unfinshed_clean_num = mysql_num_rows(mysql_query($sql));
        $res['sql'] = $sql;

        $res['status'] = 0;
        $res['clean'] = $clean_num;
        $res['unfinish'] = $unfinshed_clean_num;

}else{
  $res['status'] = 2;
  $res['msg'] = '参数错误';
}

echo json_encode($res);

?>
