<?php
ini_set('display_errors','on');
error_reporting(E_ALL);

include 'admin/connect.php';
$sessionuser='';
if(isset($_SESSION['user'])){
   $sessionuser=$_SESSION['user'];   
}
$tpl='include/temp/';//temp directory
$lang='admin/include/langs/';
$func='admin/include/function/';
$css='admin/layout/css/';//css directory
$js='admin/layout/js/';//js directory

?>
<?php


include $func.'func.php';
include $lang.'english.php';
include $tpl.'head.php';



