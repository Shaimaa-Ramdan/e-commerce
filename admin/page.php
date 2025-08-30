<?php
$do='';
if(isset($_GET['do'])){
    $do=$_GET['do'];
}else{
    $do='manage';
}
if($do =='manage'){echo 'welcome you are in manage page';
 echo'<a href="page.php?do=add">Add New categorie +</a>';}
elseif($do =='add'){echo 'welcome you are in add page';}
elseif($do =='insert'){echo 'welcome you are in insert page';}
else{echo 'welcome you are in manage page';}