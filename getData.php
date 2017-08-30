<?php
session_start();
require_once('conn.php');
$user = $_GET['user'];
$action = $_GET['action'];
$res = array();

if($action == 'index'){
  $res = getData($user, 'mark', 1);
}elseif($action=='filter'){
  $res = getData($user ,'filter', 2);
}elseif($action=="clean"){
  $res = getData($user, 'clean', 3);
}else{
  $res['status'] = 2;
  $res['msg'] = '参数错误!';
}

echo json_encode($res);

function getData($user, $from, $status){
  $res = array();
  // if($from == "filter") $status = 1;
  /*首先查询是否有未完成*/
  $sql = sprintf('select * from user_task where userId = %s and status = 0 and task = "%s" limit 1', $user, $from);
  // $res['sql'][] = $sql;
  $q = mysql_query($sql);
  $check = 0;
  if(mysql_num_rows($q) > 0){
    $dirId = mysql_fetch_row($q)[2];
    $check = 1;
  }
  // if($check == 0) $sql = sprintf('select * from dir where status = %s limit 1', $from == 'mark'? '0': '1');
  if($check == 0) $sql = sprintf('select * from dir where status = 0 limit 1');
  else $sql = sprintf('select * from dir where dirId = %s', $dirId);

  // $res['sql'][]= $sql;
  $q = mysql_query($sql);
  if(!$q){
    $res['status'] = -1;
    $res['msg'] = 'MysqlError:'.mysql_error();
  }else{
    if(mysql_num_rows($q) == 0){
      $res['status'] = 1;
      $res['msg'] = '无数据';
    }else{
      $res['data']=mysql_fetch_row($q);
      /*请求成功之后，　更新状态，防止重复*/
      if($check ==  0){
        $sql = sprintf('update dir set status = %s where dirId = %s', -1 * $staus, $res['data'][0]);
        if(!mysql_query($sql)){
          $res['status'] = -1;
          $res['msg'] = 'MysqlError:'.mysql_error();
        }
        /*新记录插入到user_task*/
        $sql = sprintf('insert into user_task (userId, dirId, status, task, addTime) values("%s", %s, 0, "%s","%s")',
                      $user, $res['data'][0],$from , date("Y-m-d H:i:s"));
        if(!mysql_query($sql)){
          $res['status'] = -1;
          $res['msg'] = 'MysqlError:'.mysql_error();
        }
      }
      $_SESSION['dir'] = $res['data'][0];
      $_SESSION['dirName'] = $res['data'][2];
      $_SESSION['dirStatus'] = $update_staus;
      /*在此步获取到当前目录图片的个数*/
      $sql = sprintf('select * from image where dirId = %s and status = 0', $res['data'][0]);
      $q = mysql_query($sql);
      if(!$q){
        $res['status'] = -1;
        $res['msg'] = 'MysqlError:'.mysql_error();
      }else{
        $_SESSION['picNum'] = mysql_num_rows($q);
      }
      $res['status'] = 0;
    }
  }
  $res['session'] = $_SESSION;
  return $res;
}


?>
