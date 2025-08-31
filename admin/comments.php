<?php
/*
===================================================
==manage comments page 
==you can edit delete approve comment from here
===================================================
*/
ob_start();
session_start();
$pagetitle="Comments";
if(isset($_SESSION['username'])){
        include 'init.php';
        $do='';
        if(isset($_GET['do'])){
            $do=$_GET['do'];
        }else{
            $do='manage';
}
if($do =='manage'){//manage page
    $stmt=$connect->prepare("SELECT comments.*,items.name AS Item_name,users.username AS Member
                             FROM comments
                             INNER JOIN items
                             ON items.item_id=comments.item_id
                             INNER JOIN users
                             ON users.userid=comments.user_id
                             ORDER BY c_id DESC ");
    $stmt->execute();
    $rows=$stmt->fetchALL();
    if(!empty($rows)){
    ?>
        <h1 class='text-center'>Manage comments</h1>
        <div class="container">
        <table class="table-responsive">
        <table class="main-table text-center table table-borderd">
                  <tr>
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Item name</td>
                        <td>User name</td>
                        <td>Added Date</td>
                        <td>Control</td>
                  </tr>
                  <?php
                     foreach($rows as $row){
                        
                        echo "<tr>";
                        echo "<td>".$row['c_id']."</td>";
                        echo "<td>".$row['comment']."</td>";
                        echo "<td>".$row['Item_name']."</td>";
                        echo "<td>".$row['Member']."</td>";
                        echo "<td>".$row['comm_date']."</td>";
                        echo "<td>
                        <a href='comments.php?do=edit&&commid=".$row['c_id']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                       <a href='comments.php?do=delete&commid=". $row["c_id"]."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                       if($row['status']==0){
                        echo "<a href='comments.php?do=Approve&&commid=".$row['c_id']."' class='btn btn-info activate'><i class='fa fa-check '></i>Activate</a>";
                       }
                          echo"</td>";
                            
                        echo "</tr>";
                     }
                  ?>
               
        </table>
        </table>

            </div>
        
        <?php }else{
            
            echo'<div class="alert alert-danger">There is no comments to show</div>';
             
        }}elseif($do =='edit'){//edit page
        //check if get request commid is numeric and get the interger value of it+
    $commid=isset($_GET['commid']) && is_numeric($_GET['commid'])?intval($_GET['commid']):0;
    //select all data depend on this id
    $stmt=$connect->prepare("SELECT * from comments where c_id=?");
    //execute quary
    $stmt->execute(array($commid));
    //fetch data
    $row=$stmt->fetch();
    //row count
    $count=$stmt->rowCount();
    
    if($count > 0){?>
            <h1 class="text-center">Edit comments</h1>
            <div class="container">
        <form action="?do=update" method="POST">
            <input type="hidden" name="commid" value="<?php echo  $commid?>">
            <!-- start comment field -->
            <div class="row mb-3 form-control-lg">
            <label class="col-sm-2 con-form-label">Comment</label>
            <div class="col-sm-10 col-md-4">
            <textarea class='form-control' name='comment'><?php echo $row['comment']?></textarea>
                    </div>
                </div>
                <!-- end comment field -->
                    <!-- start submit field -->
            <div class="row mb-3">
            <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="save" class="btn btn-primary btn-lg">
                    </div>
                </div>
                <!-- end submit field -->
        </form>
            </div>

       <?php ;
       }else{//else show error message if there is no such id
        echo"<div class='container'>";
        $msg="<div class='alert alert-danger'>There is no such id</div>";
        Redirecthome($msg);
        echo"</div>";
       }
       }
       elseif($do =="update"){
       echo "<h1 class='text-center'>Update comment</h1>";
       echo"<div class='container'>";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $commid     =$_POST['commid'];
            $comment    =$_POST['comment'];
    
    $stmt = $connect->prepare("UPDATE comments SET comment=?WHERE c_id=?");
    $stmt->execute(array($comment,$commid));

    $msg='<div class="alert alert-success">'.$stmt->rowCount().'record updated</div>';
    Redirecthome($msg,'back',4);
}
else{
    echo"<div class='continer'>";
    $msg="<div class='alert alert-danger'>sorry you can/'t browse this page directly</div>";
    Redirecthome($msg);
    echo"</div>";
}
    echo"</div>";
}elseif($do == 'delete'){//delete page
    echo "<h1 class='text-center'>Delete comment</h1>";
    echo"<div class='container'>";
   //check if get request userid is numeric and get the interger value of it+
    $commid=isset($_GET['commid']) && is_numeric($_GET['commid'])?intval($_GET['commid']):0;
    //select all data depend on this id
    $check=checkitem('c_id','comments',$commid);
    
    if($check >0){
       $stmt=$connect->prepare("DELETE FROM comments where c_id=:zid");
       $stmt->bindparam(":zid",$commid);
       $stmt->execute();
       $msg='<div class="alert alert-success">'.$stmt->rowCount().' Record deleted</div>';
       Redirecthome($msg,'back');
}
else{
    $msg="<div class='alert alert-danger'>this id is not exist</div>";
    Redirecthome($msg);
      }
      echo"</div>";
        }elseif($do=='Approve'){
          echo "<h1 class='text-center'>Approve comment</h1>";
    echo"<div class='container'>";
   //check if get request userid is numeric and get the interger value of it+
    $commid=isset($_GET['commid']) && is_numeric($_GET['commid'])?intval($_GET['commid']):0;
    //select all data depend on this id
    $check=checkitem('c_id','comments',$commid);
    
    if($check >0){
       $stmt=$connect->prepare("UPDATE comments set status=1 WHERE c_id=?");
     
       $stmt->execute(array($commid));
       $msg='<div class="alert alert-success">'.$stmt->rowCount().' Record Approved</div>';
       Redirecthome($msg,'back');
}
else{
    $msg="<div class='alert alert-danger'>this id is not exist</div>";
    Redirecthome($msg);
      }
      echo"</div>";  
        }
    include $tpl.'footer.php';
 
}else{
 header('location:index.php');
 exit();
}
ob_end_flush();
?>