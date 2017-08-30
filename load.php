<?php
session_start();
require_once('conn.php');

$num = $_GET['num'];
$cur_page = $_GET['cur_page'];
$action = $_GET['action'];

$pic_size = 270.0;
if($_GET['from'] == 'filter'){
    $pic_size = 400.0;
}
$res = array();
if($action == 'get'){
  if(!is_numeric($num) || !is_numeric($cur_page)){
    $res['status'] = 2;
  }else{
    $res['status'] = 0;
    $sql = sprintf('select imgId, imgPath, faces, faceNum from image  where dirId= %s and status = 0 limit %d, %d', $_SESSION['dir'], ($cur_page -1 ) * $num, $num);
    $q = mysql_query($sql);
    $page_num = mysql_num_rows($q);
    while($row = mysql_fetch_row($q)){
      $picSize = getimagesize($row[1]);
      $width = $picSize[0];
      $height = $picSize[1];
      if($width > $height){
        $height = $height * $pic_size / $width;
        $width = $pic_size;
      }else{
        $width = $width * $pic_size / $height;
        $height = $pic_size;
      }
      $faces = $row[2];
      $regIds = explode(',', $faces);
      $faceNum = count($regIds);
      for($i = 0; $i < $faceNum; $i++){
        $sql = sprintf('select * from region where regionId= %s and options >= 0', $regIds[$i]);
        $r_q = mysql_query($sql);
        while($re_row = mysql_fetch_assoc($r_q)){
         $row['region'][] = $re_row;
        }
      }
      if(!array_key_exists('region', $row)){
        $row['region'] = [];
      }
      $row['width'] = $width;
      $row['height']  = $height;
      $res['img'][] = $row;
    }
    $res['picNum'] =$_SESSION['picNum'];
    if($page_num < $num){
      $res['next'] = 0;
    }else{
      $res['next'] = 1;
    }

  }
}
echo json_encode($res);
?>
