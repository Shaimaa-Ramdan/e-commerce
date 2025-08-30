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
                       <span>2000</span> 
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
                       foreach($thelatestusers as $users){
                        echo '<li>'.$users['username'].'<a href="users.php?do=edit&userid='.$users['userid'].'" class="btn btn-success pull-right" ><span ><i class="fa fa-edit"></i>edit';
                       if($users['regesterstatus']==0){
                       echo "<a href='users.php?do=Activate&&userid=".$users['userid']."' class='btn btn-info activate'><i class='fa fa-edit '></i>Activate</a>";
                       }
                        echo'</span></a></li>';
                       }
                       echo'</ul>';
                        ?>
                       </div>
                
            </div>
        
       
           
        </div>
        <div class="col-sm-6 con-form-label">
            <div class="card card-default">
                <?php $numitems=5 ?>
                <div class="card-header">
                    <i class="fa fa-tag"></i>
                        latest items  <?php echo $numitems?>
                        <span class='toggel-info float-end'>
                                <i class='fa fa-plus fa-lg'></i>
                            </span>
                        </div>
                       <div class="card-body">
                        <?php
                      echo'<ul class="list-unstyled lastest-users">';
                       $thelatestitems= getlatest('*','items','item_id',$numitems);
                       foreach($thelatestitems as $items){
                        echo '<li>'.$items['name'].'<a href="items.php?do=edit&itemid='.$items['item_id'].'" class="btn btn-success pull-right" ><span ><i class="fa fa-edit"></i>edit';
                       if($items['Approve']==0){
                       echo "<a href='items.php?do=Approve&&itemid=".$items['item_id']."' class='btn btn-info activate'><i class='fa fa-edit '></i>Approve</a>";
                       }
                        echo'</span></a></li>';
                       }
                       echo'</ul>';
                        ?>
                       </div>
                
            </div>
        
       
           
        </div>
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