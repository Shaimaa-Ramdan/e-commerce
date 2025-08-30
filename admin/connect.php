<?php
$dsn="mysql:local=localhost;dbname=shop";
$name="root";
$pass="";
$option=array(
PDO::MYSQL_ATTR_INIT_COMMAND=>'set names utf8'
);
try{
    $connect=new PDO($dsn,$name,$pass,$option);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 
}
catch(PDOException $e){
    echo ''.$e->getmessage();
}