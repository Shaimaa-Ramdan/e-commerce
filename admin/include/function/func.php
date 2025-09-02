<?php
//echo page title if variable $pagetitle exist
function gettitle(){
    global  $pagetitle;
    if(isset( $pagetitle)){
        echo  $pagetitle;
    }
    else{
        echo'defoult';
    }
}
/************************************************
 **Home redirect function accept parameter v2.0
 **msg echo msg(error,warning,success)
 **url page who will redirect to
 **second time before redirect to home page
 ***********************************************/
function Redirecthome($msg,$url=null,$seconds=3){
    if($url===null){
        $url="index.php";
        $link='Homepage';
    }else{
        if(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!==''){
           $url= $_SERVER['HTTP_REFERER'];
           $link= 'previous page';
       
    }else{
           $url= 'index.php';
           $link= 'Home page';
        }}
    echo $msg;
    header("refresh:$seconds;url=$url");
    echo"<div class='alert alert-info'>You will be redirected to $link after$seconds seconds</div>";
   
    exit();
}
/*************************************
 **** function check item v1.0
 **** $select the item that selected
 **** $from the table which item selected
 **** $value the value of select
 ****************************************/
function checkitem($select,$from,$value){
   global $connect ;
   $statement=$connect->prepare("SELECT $select FROM $from WHERE $select=?");
   $statement->execute(array($value));
    $count=$statement->rowCount();
    return $count;
}
/*************************************
 **** function count item v1.0
 **** item the item to count
 **** table the table to choose from
 ****************************************/
function itemcount($item,$table){
    global $connect; 
    $stmt2=$connect->prepare("SELECT COUNT($item) From $table");
    $stmt2->execute();
    return $stmt2->fetchcolumn(); 

}
/*************************************
 **** function get latest v1.0
 **** select the item to select
 **** table which from we select
 **** table which from we select
 **** limit numbers of recordes you get
 ****************************************/
function getlatest($select,$table,$order,$limit=5){
    global $connect;
    $stmt3=$connect->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit ");
    $stmt3->execute();
    $row=$stmt3->fetchall();
    return $row;
}
/*************************************
 **** function get cat from data base v1.0
 ****************************************/
function getcat(){
    global $connect;
    $getcat=$connect->prepare("SELECT * FROM categories ORDER BY id ASC ");
    $getcat->execute();
    $cats=$getcat->fetchall();
    return $cats;
}
/*************************************
 **** function get cat from data base v1.0
 ****************************************/
function gettcat($catid){
    global $connect;
    $getitem=$connect->prepare("SELECT * FROM items WHERE cat_id=? ORDER BY item_id DESC ");
    $getitem->execute(array($catid));
    $items=$getitem->fetchall();
    return $items;
}
/*************************************
 **** function get cat from data base v1.0
 ****************************************/
function getitem($itemid){
    global $connect;
    $getitem=$connect->prepare("SELECT * FROM items WHERE item_id=? ORDER BY item_id DESC ");
    $getitem->execute(array($itemid));
    $items=$getitem->fetchall();
    return $items;
}
