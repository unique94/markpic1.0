<?php
$server_name = $_SERVER['HTTP_HOST'];
error_reporting(E_ERROR);

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_CHARSET', 'utf-8');
define('DB_NAME', 'opzoonFace');

if(strstr($server_name,'localhost') != ""){
    $server_name = 'localhost/markpic';
    define('DB_PWD', '123456');
}
else{
    $server_name = 'http://101.200.169.35/markpic/';
    define('DB_PWD', '123qwe');
}

$db = mysql_connect(DB_HOST, DB_USER, DB_PWD) or die ("数据库连接错误: " . mysql_error());
mysql_select_db(DB_NAME, $db);
mysql_set_charset(DB_CHARSET,$db);

?>
