<?php
session_start();
$nonavbar='';
$pagetitle='login';
if(isset($_SESSION['username'])){
    header('location:dashboard.php');
}
include "init.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedpass = sha1( $password);
    //check if user exist in database
    $stmt= $connect->prepare("SELECT 
                                   userid,username,password
                               FROM 
                                     users     
                                WHERE      
                                      username=? 
                                AND 
                                    password=?
                                 AND
                                      groupid=1
                                      LIMIT 1");
    $stmt->execute(array($username,$hashedpass));
    $row = $stmt->fetch();
    $count=$stmt->rowCount();
    if($count>0){
        $_SESSION['username']=$username;
        $_SESSION['userid']=$row['userid'];
        header('location:dashboard.php');

    }
}

?>


<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <h4 class="text-center">admin login </h4>
<input class="form-control " type="name" name="user" placeholder="username" autocomplete="off"/>
<input class="form-control " type="password" name="pass" placeholder="password" autocomplete="new-password"/>
<input class="btn btn-primary btn-block" type="submit" value="login" />

</form>
<?php include $tpl.'footer.php';