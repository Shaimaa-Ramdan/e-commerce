<?php
/*
===================================================
==manage member page 
==you can add edit delete
===================================================
*/
ob_start();
session_start();
$pagetitle="Edit Members";
if(isset($_SESSION['username'])){
        include 'init.php';
        $do='';
        if(isset($_GET['do'])){
            $do=$_GET['do'];
        }else{
            $do='manage';
}
if($do =='manage'){//manage page
    $quary='';
    if(isset($_GET['page'])&& $_GET['page']=='pending'){
       $quary='and regesterstatus = 0'; 
    }
    $stmt=$connect->prepare("SELECT * FROM users WHERE groupid!=1 $quary");
    $stmt->execute();
    $rows=$stmt->fetchALL();
    ?>
        <h1 class='text-center'>Manage Member</h1>
        <div class="container">
        <table class="table-responsive">
        <table class="main-table text-center table table-borderd">
                  <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Fullname</td>
                        <td>Registered Date</td>
                        <td>Control</td>
                  </tr>
                  <?php
                     foreach($rows as $row){
                        
                        echo "<tr>";
                        echo "<td>".$row['userid']."</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['userfullname']."</td>";
                        echo "<td>".$row['date']."</td>";
                        echo "<td>
                        <a href='users.php?do=edit&&userid=".$row['userid']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                       <a href='users.php?do=delete&userid=". $row["userid"]."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                       if($row['regesterstatus']==0){
                        echo "<a href='users.php?do=Activate&&userid=".$row['userid']."' class='btn btn-info activate'><i class='fa fa-check '></i>Activate</a>";
                       }
                          echo"</td>";
                            
                        echo "</tr>";
                     }
                  ?>
               
        </table>
        </table>
      <a href="users.php?do=Add" class='btn btn-primary'><i class="fa fa-plus"></i>Add Member</a>
            </div>
        
        <?php } elseif($do =='Add'){?>
        <h1 class="text-center">Add Members</h1>
            <div class="container">
        <form action="?do=insert" method="POST">
            <input type="hidden" name="userid">
            <!-- start username field -->
            <div class="row mb-1 form-control-lg input-wrapper" >
            <label class="col-sm-2 lg">username</label>
            <div class="col-sm-10 col-md-4">
            <input type="text" name="username" class="form-control "autocomplete="off" required="required" placeholder="username to login">
                    </div>
                </div>
                <!-- end username field -->
                    <!-- start password field -->
            <div class="row mb-3 form-control-lg input-wrapper" >
            <label class="col-sm-2 con-form-label">password</label>
            <div class="col-sm-10 col-md-4">
            <input type="password" name="password" class="form-control password"autocomplete="new-password"placeholder="password should be complex and hard" required="required">
            <i class='show-pass fa-solid fa-eye fa-2x'></i>
                    </div>
                </div>
                <!-- end password field -->
                    <!-- start email field -->
            <div class="row mb-3 form-control-lg input-wrapper">
            <label class="col-sm-2 con-form-label">email</label>
            <div class="col-sm-10 col-md-4">
            <input type="email" name="email"  class="form-control"autocomplete="off" required="required" placeholder="email must be valid">
                    </div>
                </div>
                <!-- end email field -->
                    <!-- start fullname field -->
            <div class="row mb-3 form-control-lg">
            <label class="col-sm-2 con-form-label">fullname</label>
            <div class="col-sm-10 col-md-4">
            <input type="text" name="fullname"   class="form-control"autocomplete="off" required="required" placeholder="name of profile">
                    </div>
                </div>
                <!-- end fullname field -->
                    <!-- start submit field -->
            <div class="row mb-3">
            <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="add member" class="btn btn-primary btn-lg">
                    </div>
                </div>
                <!-- end submit field -->
        </form>
        
        </div>
        
        <?php

        }elseif($do=="insert"){ 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
     echo "<h1 class='text-center'>Insert member</h1>";
          echo"<div class='container'></div>";
   
    $user   =$_POST['username'];
    $pass   =$_POST['password'];
    $email  =$_POST['email'];
    $name   =$_POST['fullname'];
    $hashpassword=sha1($_POST['password']);
    
    //validate the form
    $formerrors = array();
 if(strlen($user)>20){$formerrors[]='username cant be more than <strong>20 </strong>character';}
 if(strlen($user)<4){$formerrors[]='username cant be less than<strong> 4 </strong>character';}
 if(empty($user)){$formerrors[]='username cant be<strong> empty</strong>';}
 if(empty($pass)){$formerrors[]='password cant be<strong> empty</strong>';}
 if(empty($email)){$formerrors[]='email cant be<strong> empty</strong>';}
 if(empty($name)){$formerrors[]='fullname cant be<strong> empty</strong>';}
 foreach($formerrors as $error){echo '<div class="alert alert-danger">'.$error.'</div>';}
 //update database with this info
 if(empty( $formerrors ) ){
    //check if user exist in database
    $check=Checkitem("username","users",$user);
    if($check==1){
    $msg="<div class='alert alert-danger'>sorry this username exist in database</div>";
    Redirecthome($msg,'back');
    }else{
            $stmt=$connect->prepare("INSERT INTO
                                        users(username,password,email,userfullname,regesterstatus,date)
                                    VALUES(:Ausername,:Apassword,:Aemail,:Auserfullname,1,now()) ");
            $stmt->execute(array(
            'Ausername' => $user,
            'Apassword' => $hashpassword,
            'Aemail' => $email,
            'Auserfullname' => $name

            )) ;                        
        $msg='<div class="alert alert-success">'.$stmt->rowCount().' Record inserted</div>';
        Redirecthome($msg,'back');
            }


 }

   
}else{
   
}
        }
           
        
    elseif($do =='edit'){//edit page
        //check if get request userid is numeric and get the interger value of it+
    $userid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
    //select all data depend on this id
    $stmt=$connect->prepare("SELECT * from users where userid=? LIMIT 1");
    //execute quary
    $stmt->execute(array($userid));
    //fetch data
    $row=$stmt->fetch();
    //row count
    $count=$stmt->rowCount();
    
    if($count > 0){?>
            <h1 class="text-center">Edit Members</h1>
            <div class="container">
        <form action="?do=update" method="POST">
            <input type="hidden" name="userid" value="<?php echo  $userid?>">
            <!-- start username field -->
            <div class="row mb-3 form-control-lg">
            <label class="col-sm-2 con-form-label">username</label>
            <div class="col-sm-10 col-md-4">
            <input type="text" name="username" value="<?php echo $row['username']?>" class="form-control "autocomplete="off" required="required">
                    </div>
                </div>
                <!-- end username field -->
                    <!-- start password field -->
            <div class="row mb-3 form-control-lg">
            <label class="col-sm-2 con-form-label">password</label>
            <div class="col-sm-10 col-md-4">
            <input type="hidden" name="oldpassword" value="<?php echo $row['password']?>">
            <input type="password" name="newpassword" class="form-control"autocomplete="new-password"placeholder="leave blank if you dont want to change">
                    </div>
                </div>
                <!-- end password field -->
                    <!-- start email field -->
            <div class="row mb-3 form-control-lg">
            <label class="col-sm-2 con-form-label">email</label>
            <div class="col-sm-10 col-md-4">
            <input type="email" name="email" value="<?php echo $row['email']?>"  class="form-control"autocomplete="off" required="required">
                    </div>
                </div>
                <!-- end email field -->
                    <!-- start fullname field -->
            <div class="row mb-3 form-control-lg">
            <label class="col-sm-2 con-form-label">fullname</label>
            <div class="col-sm-10 col-md-4">
            <input type="text" name="fullname" value="<?php echo $row['userfullname']?>"  class="form-control"autocomplete="off" required="required">
                    </div>
                </div>
                <!-- end fullname field -->
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
        echo "<h1 class='text-center'>Update member</h1>";
          echo"<div class='container'>";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id     =$_POST['userid'];
    $user   =$_POST['username'];
    $email  =$_POST['email'];
    $name   =$_POST['fullname'];
    //password trick
    $pass=empty($_POST['newpassword'])?$_POST['oldpassword']:sha1($_POST['newpassword']);
  
    //validate the form
     $formerrors = array();
 if(strlen($user)>20){$formerrors[]='username cant be more than <strong>20 </strong>character';}
 if(strlen($user)<4){$formerrors[]='username cant be less than<strong> 4 </strong>character';}
 if(empty($user)){$formerrors[]='username cant be<strong> empty</strong>';}
 if(empty($pass)){$formerrors[]='password cant be<strong> empty</strong>';}
 if(empty($email)){$formerrors[]='email cant be<strong> empty</strong>';}
 if(empty($name)){$formerrors[]='fullname cant be<strong> empty</strong>';}
 foreach($formerrors as $error){echo '<div class="alert alert-danger">'.$error.'</div>';}
 //update database with this info
if (empty($formerrors)) {
    $stmt = $connect->prepare("UPDATE users SET username=?, email=?, userfullname=?, password=? WHERE userid=?");
    $stmt->execute([$user, $email, $name, $pass, $id]);

    $msg='<div class="alert alert-success">'.$stmt->rowCount().'record updated</div>';
    Redirecthome($msg,'back',4);
}

}else{
    echo"<div class='continer'>";
    $msg="<div class='alert alert-danger'>sorry you can/'t browse this page directly</div>";
    Redirecthome($msg);
    echo"</div>";
}
    echo"</div>";
}elseif($do == 'delete'){//delete page
    echo "<h1 class='text-center'>Delete member</h1>";
    echo"<div class='container'>";
   //check if get request userid is numeric and get the interger value of it+
    $userid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
    //select all data depend on this id
    $check=checkitem('userid','users',$userid);
    
    if($check >0){
       $stmt=$connect->prepare("DELETE FROM users where userid=:zuserid");
       $stmt->bindparam(":zuserid",$userid);
       $stmt->execute();
       $msg='<div class="alert alert-success">'.$stmt->rowCount().' Record deleted</div>';
       Redirecthome($msg);
}
else{
    $msg="<div class='alert alert-danger'>this id is not exist</div>";
    Redirecthome($msg);
      }
      echo"</div>";
        }elseif($do=='Activate'){
          echo "<h1 class='text-center'>Activate member</h1>";
    echo"<div class='container'>";
   //check if get request userid is numeric and get the interger value of it+
    $userid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
    //select all data depend on this id
    $check=checkitem('userid','users',$userid);
    
    if($check >0){
       $stmt=$connect->prepare("UPDATE users set regesterstatus=1 WHERE userid=?");
     
       $stmt->execute(array($userid));
       $msg='<div class="alert alert-success">'.$stmt->rowCount().' Record Activated</div>';
       Redirecthome($msg);
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