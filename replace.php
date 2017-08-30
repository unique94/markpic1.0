<?php
$oldsrc = $_POST['oldsrc'];
$newsrc = $_POST['newsrc'];
$filename = './newfile.txt';
file_put_contents($filename,'hello,world');
?>
