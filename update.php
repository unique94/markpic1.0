<?php
session_start();
require_once('conn.php');
$regions_list = $_POST['data'];
$action = $_POST['action'];
$res = array();

if($action == 'update'){
  /**
   * options:
   *  -1: 无效
   *  1 : 人为修改
   *  0 : 算法检测正确
   */
try{
  foreach($regions_list as $id => $regions){
    // $res['msg'][] = 'start '.$id;
    for($f = 1; $f < count($regions); $f ++){
      $cur_reg = $regions[$f];
      if(array_key_exists('regionId', $cur_reg)){
        //已经存在与数据库，但是错误标记
        if($cur_reg['options'] < 0){
          $sql = sprintf('update region set options = %s where regionId= %s', $cur_reg['options'], $cur_reg['regionId']);
        //  $res['sql'][] = $sql;
          if(!mysql_query($sql)){
            $res['log'][] = 'Error:'.$id.'regionId:'.$regions_list['regionId'].mysql.error();
            continue;
          }
        }
      }
      else{
        if($cur_reg['options'] < 0) continue;
        $sql = sprintf('insert into region (imgId, x, y, h, w, status, options) values(%s, %s, %s, %s, %s, %s, %s)',
          $id, $cur_reg['x'], $cur_reg['y'], $cur_reg['h'], $cur_reg['w'], '0', $cur_reg['options']);
      //  $res['msg'][] = $sql;
        if(!mysql_query($sql)){
          $res['log'][] = 'Error:'.$id.'regionId:'.$regions_list['regionId'].mysql.error();
          continue;
        }else{
          $regionId = mysql_insert_id();
          $sql = sprintf('update image set faces= concat(faces,",%s") where imgId=%s', $regionId, $id);
         // $res['msg'][] = $sql;
          if(!mysql_query($sql)){
            $res['log'][] = 'Error:'.$id.'regionId:'.$regions_list['regionId'].mysql.error();
            continue;
          }
        }
      }
    }
  }
  $res['status'] = 0;
}catch(Exception $e){
    $res['status'] = 3;
    $res['msg'] = 'error';
}
}elseif($action == 'filter'){
  if($regions_list == ""){
    $res['status'] = 0;
  }else{
  foreach($regions_list as $rId=>$flag){
    $sql = 'update region set options= -3 where regionId='.$rId;
    if(!mysql_query($sql)){
      $res['status'] = 2;
      $res['msg'] = 'sql error:'.mysql_error();
    }else{
      $res['status'] = 0;
    }
  }
}
}elseif($action == 'clean'){
  if($regions_list == ""){
    $res['status'] = 0;
  }else{
  foreach($regions_list as $id=>$flag){
    $sql = 'update image set status= -1 where imgId='.$id;
    if(!mysql_query($sql)){
      $res['status'] = 2;
      $res['msg'] = 'sql error:'.mysql_error();
    }else{
      $res['status'] = 0;
    }
  }
  }
}elseif($action == 'finish'){
  $from = $_POST['from'];
  $status = $_POST['status'];
  if($from == '' || !($status < 4)){
    $res['status'] = 2;
    $res['msg'] = '参数错误';
  }else{
    $sql = sprintf('update dir set status = %s where dirId= %s', $status, $_SESSION['dir']);
    $check = 0;
    if(!mysql_query($sql)){
      $res['status'] = -1;
      $res['msg'] = 'MySql Error: '. mysql_error();
      $check = 1;
    }
    $sql = sprintf('update user_task set status = 1 where userId = "%s" and dirId= %s and status = 0', $_SESSION['user'], $_SESSION['dir']);
    $_SESSION['clean_num'] = $_SESSION['clean_num'] + 1;
    $un_clean_num = $_SESSION['unfinished_clean_num'];
    if($un_clean_num > 0) $un_clean_num -= 1;
    $_SESSION['unfinished_clean_num'] = $un_clean_num;
    if(!mysql_query($sql)){
      $res['status'] = -1;
      $res['msg'] = 'MySql Error: '. mysql_error();
      $check = 1;
    }
    if($check == 0) $res['status'] = 0;
  }

}else{
  $res['status'] = 2;
  $res['message'] = '参数错误!';
}

echo json_encode($res);
?>
