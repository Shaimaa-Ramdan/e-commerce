<?php
session_start();
$pagetitle='Home page';
include "init.php";
if(isset($_SESSION['user'])){
    $getuser=$connect->prepare("SELECT * FROM users WHERE username=? ");
    $getuser->execute(array($sessionuser));
    $info=$getuser->fetch();
?>
<h1 class='text-center'>My Profile</h1>
<div class='information block'>
    <div class='container'>
        <div class='card card-primary'>
            <div class='card card-header'>My information</div>
            <div class='card card-body'>
                <ul class="list-unstyled">
                   <li>
                    <i class="fa fa-unlock-alt fa-fw"></i>
                    <span>Login Name</span>:<?php echo $info['username']?>
                   </li>
                   <li>
                    <i class="fa-regular fa-envelope fa-fw"></i>
                    <span>Email</span>:<?php echo $info['email']?>
                   </li>
                   <li>
                   <i class="fa fa-user fa-fw"></i>
                    <span>Fullname</span>:<?php echo $info['userfullname']?>
                   </li>
                   <li>
                    <i class="fa-regular fa-calendar fa-fw"></i>
                    <span>Regester Date</span>:<?php echo $info['date']?>
                   </li>
                   <li>
                    <i class="fa fa-tag fa-fw"></i>
                    <span>Favourite Category</span>
                   </li>
                </ul>
            </div>
         </div>
    </div>
</div>
<div class='latest-ads block'>
    <div class='container'>
        <div class='card card-primary'>
            <div class='card card-header'>Latest Ads</div>
            <div class='card card-body'>
                <div class="row">
    <?php
    if(!empty(gettcat("users_id" , $info['userid']))){
   
    foreach(gettcat("users_id" , $info['userid'] )as $item){
  
        echo'<div class="col-sm-6 col-md-4">';
           echo'<div class="thumbnail">';
           echo'<span class="price-tag">'.$item['price'].'</span>';
             echo'<img class="img-responsive" src="data/upload/microphone.jpg" alt="microphone" weight="250px" height="300px">';
             echo'<div class="caption">';
             echo'<h3>'.$item['name'].'</h3>';
             echo'<p>'.$item['describtion'].'</p>';
             echo'</div>';
             echo'</div>';
             echo'</div>';
           
    }}else{
        echo 'There Is No Ads To Show ,create<a href="newad.php">New ad</a>';
    } 
    ?>
    
</div>
            </div>
         </div>
    </div>
</div>
<div class='latest-comments block'>
    <div class='container'>
        <div class='card card-primary'>
            <div class='card card-header'>Latest comments</div>
            <div class='card card-body'><?php
                $stmt=$connect->prepare("SELECT comment FROM comments WHERE user_id=?");
                            $stmt->execute(array($info['userid']));
                            $comments=$stmt->fetchALL();
                            if(!empty($comments)){
                                foreach($comments as $comment){
                                echo'<p>'.$comment["comment"].'</p>';
                                }
                            }
                            else{echo'There is no comments to show';}
                            ?>
            </div>
         </div>
    </div>
</div>
<?php }
else{
    header("location:login.php");
    exit();
}

include $tpl.'footer.php';