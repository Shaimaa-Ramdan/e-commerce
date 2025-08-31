<?php
ob_start();
session_start();
if(isset($_SESSION['username'])){
    $pagetitle='dashboard';
    include 'init.php';
    /*start dashboard*/
    ?>
    <div class='container home-stat text-center'>
        <h1 class='text-center'>Dashboard</h1>
        <div class='row'>
                <div class='col-md 3'>
                    <div class='stat st-members'>
                        <i class='fa fa-users'></i>
                        <div class='info'>
                        Total members
                        <span><a href="users.php"><?php echo itemcount('userid','users')?></a></span>
                        </div>
                    </div>
                </div>
                <div class='col-md 3'>
                    <div class='stat st-pending'>
                        <i class='fa fa-user-plus'></i>
                        <div class='info'>
                    Pending members
                         <span><a href="users.php?do=manage&page=pending"><?php echo checkitem('regesterstatus','users',0)?></a></span>
                         </div>
                    </div>
                </div>
                <div class='col-md 3'>
                    <div class='stat st-items'>
                         <i class='fa fa-tag'></i>
                      <div class='info'> 
                    Total items
                         <span><a href="items.php"><?php echo itemcount('item_id','items')?></a></span>
                         </div>
                    </div>
                </div>
                <div class='col-md 3'>
                    <div class='stat st-comments'>
                        <i class='fa fa-comments'></i>
                        <div class='info'>Total comments
                       <span><a href="comments.php"><?php echo itemcount('c_id','comments')?></a></span> 
                       </div>
                    </div>
                </div>
        </div>
</div>
<div class="container latest">
    <div class="row">
        <div class="col-sm-6 con-form-label">
            <div class="card card-default">
                <?php $numusers=5 ?>
                <div class="card-header">
                    <i class="fa fa-users"></i>
                        latest regesterd users <?php echo $numusers?>
                            <span class='toggel-info float-end'>
                                <i class='fa fa-plus fa-lg'></i>
                            </span>
                </div>
                       <div class="card-body">
                       <?php
                      echo'<ul class="list-unstyled lastest-users">';
                       $thelatestusers= getlatest('*','users','date',$numusers);
                       if(!empty($thelatestusers)){
                       foreach($thelatestusers as $users){
                        echo '<li>'.$users['username'].'<a href="users.php?do=edit&userid='.$users['userid'].'" class="btn btn-success pull-right" ><span ><i class="fa fa-edit"></i>edit';
                       if($users['regesterstatus']==0){
                       echo "<a href='users.php?do=Activate&&userid=".$users['userid']."' class='btn btn-info activate'><i class='fa fa-edit '></i>Activate</a>";
                       }
                        echo'</span></a></li>';
                       }
                       echo'</ul>';
                    }else{
                        echo'There is no users to show';
                    }
                        ?>
                       </div>
                
            </div>
        </div>
        <div class="col-sm-6 con-form-label">
            <div class="card card-default">
                <?php $numitems=5 ?>
                <div class="card-header">
                    <i class="fa fa-tag"></i>
                        latest <?php echo $numitems?> items  
                        <span class='toggel-info float-end'>
                                <i class='fa fa-plus fa-lg'></i>
                            </span>
                        </div>
                       <div class="card-body">
                        <?php
                      echo'<ul class="list-unstyled lastest-users">';
                       $thelatestitems= getlatest('*','items','item_id',$numitems);
                    if(!empty($thelatestitems)){
                       foreach($thelatestitems as $items){
                        echo '<li>'.$items['name'].'<a href="items.php?do=edit&itemid='.$items['item_id'].'" class="btn btn-success pull-right" ><span ><i class="fa fa-edit"></i>edit';
                       if($items['Approve']==0){
                       echo "<a href='items.php?do=Approve&&itemid=".$items['item_id']."' class='btn btn-info activate'><i class='fa fa-edit '></i>Approve</a>";
                       }
                        echo'</span></a></li>';
                       }
                    }else{
                        echo'There is no items to show';
                    }
                       echo'</ul>';
                        ?>
                       </div>
            </div>
       </div>
    </div>

     <!-- start latest comment -->
     <div class="row">
        <div class="col-sm-6 con-form-label">
            <div class="card card-default">
                <?php $numusers=5 ?>
                <div class="card-header">
                    <i class="fa fa-comments"></i>
                        latest <?php echo$numusers?> comments
                            <span class='toggel-info float-end'>
                                <i class='fa fa-plus fa-lg'></i>
                            </span>
                        </div>
                       <div class="card-body">
                        <?php
                       $stmt=$connect->prepare("SELECT comments.*,users.username AS Member
                             FROM comments
                             INNER JOIN users
                             ON users.userid=comments.user_id
                             ORDER BY c_id DESC
                              LIMIT $numusers
                              ");
                                $stmt->execute();
                                $comments=$stmt->fetchALL();
                                if(!empty($comments)){
                                foreach($comments as $comment){
                                    echo'<div class="comment-box">';
                                    echo '<span class="member-n">'.$comment['Member'].'</span>';
                                    echo '<p class="member-c">'.$comment['comment'].'</p>';
                                    echo'</div>';?>
                                    <div class='btns'>
                                   <a href='comments.php?do=edit&commid=<?php echo $comment['c_id']?>' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                   <a href='comments.php?do=delete&commid=<?php echo $comment['c_id']?>' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>

                                   </div>
                                <?php }
                                    
                                }else{
                                    echo'There is no comments to show';
                                }

    ?>
                       </div>
                         </div>
                           </div>
                        <!--end latest comment -- -->
                       </div>
            </div>         
                
     <?php      
     
    /*end dashboard*/
    include $tpl.'footer.php';
 
}else{
 header('location:index.php');
 exit();
}
ob_end_flush();
?>