<?php
ob_start();
session_start();
$pagetitle="Items";
if(isset($_SESSION['username'])){
    include 'init.php';
    $do=isset($_GET['do'])?$_GET['do']:'manage';
    if($do=='manage'){
       
    $stmt=$connect->prepare("SELECT
                                items.*, categories.name,users.username 
                            FROM
                                items
                           INNER JOIN 
                                categories
                            ON
                                categories.id = items.cat_id 
                            INNER JOIN
                                 users
                             on
                                 users.userid=items.users_id;");
    $stmt->execute();
    $items=$stmt->fetchALL();
    ?>
        <h1 class='text-center'>Manage items</h1>
        <div class="container">
        <table class="table-responsive">
        <table class="main-table text-center table table-borderd">
                  <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Describtion</td>
                        <td>Price</td>
                        <td>Adding Date</td>
                        <td>Category</td>
                        <td>Username</td>
                        <td>Control</td>
                  </tr>
                  <?php
                     foreach($items as $item){
                        
                        echo "<tr>";
                        echo "<td>".$item['item_id']."</td>";
                        echo "<td>".$item['name']."</td>";
                        echo "<td>".$item['describtion']."</td>";
                        echo "<td>".$item['price']."</td>";
                        echo "<td>".$item['add_date']."</td>";
                        echo "<td>".$item['name']."</td>";
                        echo "<td>".$item['username']."</td>";
                        echo "<td>
                        <a href='items.php?do=edit&&itemid=".$item['item_id']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                       <a href='items.php?do=delete&itemid=". $item["item_id"]."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                       if($item['Approve'] == 0){
                        echo "<a href='items.php?do=Approve&&itemid=".$item['item_id']."' class='btn btn-info activate'><i class='fa fa-check '></i>Approve</a>";
                       }
                          echo"</td>";
                            
                        echo "</tr>";
                     }
                  ?>
               
        </table>
        </table>
      <a href="items.php?do=add" class='btn btn-sm btn-primary'><i class="fa fa-plus"></i>Add item</a>
            </div>
        
        <?php 
    }
    elseif($do=='add'){?>
        <h1 class="text-center">Add New Items</h1>
        <div class="container">
            <form action="?do=insert" method="POST">
            <input type="hidden" name="userid">
            <!-- start name field-->
            <div class="row mb-1 form-control-lg input-wrapper" >
            <label class="col-sm-2 lg">Item</label>
            <div class="col-sm-10 col-md-4">
            <input type="text"
                   name="name"
                   class="form-control "
                   required='required'
                   autocomplete="off"
                  
                   placeholder="Name of the Item">
                    </div>
                </div> 
                <!-- end name field-->
                 <!-- start describtion field-->
            <div class="row mb-1 form-control-lg input-wrapper" >
            <label class="col-sm-2 lg">Describtion</label>
            <div class="col-sm-10 col-md-4">
            <input type="text"
                   name="Describtion"
                  class="form-control "
                  required='required'
                  autocomplete="off"  
                  placeholder="Describtion of the Item">
                    </div>
                </div> 
                <!-- end Describtion field-->
                 <!-- start price field-->
            <div class="row mb-1 form-control-lg input-wrapper" >
            <label class="col-sm-2 lg">price</label>
            <div class="col-sm-10 col-md-4">
            <input type="text"
                   name="price"
                  class="form-control "
                  required='required'
                  autocomplete="off"   
                  placeholder="price of the Item">
                    </div>
                </div> 
                <!-- end price field-->
                  <!-- start country field-->
            <div class="row mb-1 form-control-lg input-wrapper" >
            <label class="col-sm-2 lg">country</label>
            <div class="col-sm-10 col-md-4">
            <input type="text"
                   name="country"
                  class="form-control "
                  required='required'
                  autocomplete="off" 
                  placeholder="country of the Item">
                    </div>
                </div> 
                <!-- end country field-->
                  <!-- start status field-->
            <div class="row mb-1  input-wrapper status" >
            <label class="col-sm-2 lg ">Status</label>
            <div class="col-sm-10 col-md-4">
            <select name="status" class="form-control">
                <option value='0'>...</option>
                <option value='1'>New</option>
                <option value='2'>LIKE NEW</option>
                <option value='3'>USED</option>
                <option value='4'>OLD</option>
               

            </select>
                    </div>
                </div> 
                <!-- end status field-->
                 <!-- start members field-->
            <div class="row mb-1  input-wrapper status" >
            <label class="col-sm-2 lg ">Members</label>
            <div class="col-sm-10 col-md-4">
            <select name="Members" class="form-control">
                <option value='0'>...</option>
                <?php
                $stmt=$connect->prepare("SELECT * FROM users");
                $stmt->execute();
                $users=$stmt->fetchAll();
                foreach($users as $user){
                echo"<option value='".$user['userid']."'>".$user['username']."</option>";
                                        }
                ?>
            </select>
                    </div>
                </div> 
                <!-- end members field-->
                 <!-- start cat field-->
            <div class="row mb-1  input-wrapper status" >
            <label class="col-sm-2 lg ">Categories</label>
            <div class="col-sm-10 col-md-4">
            <select name="Categories" class="form-control">
                <option value='0'>...</option>
                <?php
                $stmt2=$connect->prepare("SELECT * FROM categories");
                $stmt2->execute();
                $cats=$stmt2->fetchAll();
                foreach($cats as $cat){
                echo"<option value='".$cat['id']."'>".$cat['name']."</option>";
                                        }
                ?>
            </select>
                    </div>
                </div> 
                <!-- end cat field-->
                  <!-- start submit field -->
            <div class="row mb-3">
            <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="add Item" class="btn btn-primary btn-sm">
                    </div>
                </div>
                <!-- end submit field -->
           </form>
        </div>
    <?php }
    elseif($do=='edit'){
    //check if get request itemid is numeric and get the interger value of it+
    $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
    //select all data depend on this id
    $stmt=$connect->prepare("SELECT * from items where item_id=?");
    //execute quary
    $stmt->execute(array($itemid));
    //fetch data
    $item=$stmt->fetch();
    //row count
    $count=$stmt->rowCount();
    
    if($count > 0){?>
    <h1 class="text-center">Edit Items</h1>
        <div class="container">
            <form action="?do=update" method="POST">
                <input type='hidden' name='itemid' value='<?php echo $itemid?>'>
            <input type="hidden" name="userid">
            <!-- start name field-->
            <div class="row mb-1 form-control-lg input-wrapper" >
            <label class="col-sm-2 lg">Item</label>
            <div class="col-sm-10 col-md-4">
            <input type="text"
                   name="name"
                   class="form-control "
                   required='required'
                   autocomplete="off"
                   value="<?php echo $item['name'] ?>"
                   placeholder="Name of the Item">
                    </div>
                </div> 
                <!-- end name field-->
                 <!-- start describtion field-->
            <div class="row mb-1 form-control-lg input-wrapper" >
            <label class="col-sm-2 lg">Describtion</label>
            <div class="col-sm-10 col-md-4">
            <input type="text"
                   name="Describtion"
                  class="form-control "
                  required='required'
                  autocomplete="off" 
                  value="<?php echo $item['describtion'] ?>"
                  placeholder="Describtion of the Item">
                    </div>
                </div> 
                <!-- end Describtion field-->
                 <!-- start price field-->
            <div class="row mb-1 form-control-lg input-wrapper" >
            <label class="col-sm-2 lg">price</label>
            <div class="col-sm-10 col-md-4">
            <input type="text"
                   name="price"
                  class="form-control "
                  required='required'
                  autocomplete="off" 
                  value="<?php echo $item['price'] ?>"  
                  placeholder="price of the Item">
                    </div>
                </div> 
                <!-- end price field-->
                  <!-- start country field-->
            <div class="row mb-1 form-control-lg input-wrapper" >
            <label class="col-sm-2 lg">country</label>
            <div class="col-sm-10 col-md-4">
            <input type="text"
                   name="country"
                  class="form-control "
                  required='required'
                  autocomplete="off"
                  value="<?php echo $item['country_made'] ?>" 
                  placeholder="country of the Item">
                    </div>
                </div> 
                <!-- end country field-->
                  <!-- start status field-->
            <div class="row mb-1  input-wrapper status" >
            <label class="col-sm-2 lg ">Status</label>
            <div class="col-sm-10 col-md-4">
            <select name="status" class="form-control">
                <option value='0'<?php if($item['status'] == 0){echo 'selected';}?>>...</option>
                <option value='1'<?php if($item['status'] == 1){echo 'selected';}?>>New</option>
                <option value='2'<?php if($item['status'] == 2){echo 'selected';}?>>LIKE NEW</option>
                <option value='3'<?php if($item['status'] == 3){echo 'selected';}?>>USED</option>
                <option value='4'<?php if($item['status'] == 4){echo 'selected';}?>>OLD</option>
               

            </select>
                    </div>
                </div> 
                <!-- end status field-->
                 <!-- start members field-->
            <div class="row mb-1  input-wrapper status" >
            <label class="col-sm-2 lg ">Members</label>
            <div class="col-sm-10 col-md-4">
            <select name="Members" class="form-control">
                <option value='0'>...</option>
                <?php
                $stmt=$connect->prepare("SELECT * FROM users");
                $stmt->execute();
                $users=$stmt->fetchAll();
                foreach($users as $user){
                echo"<option value='".$user['userid']."'";
                 if($item['users_id'] == $user['userid']){echo 'selected';}
                 echo ">".$user['username']."</option>";
                                        }
                ?>
            </select>
                    </div>
                </div> 
                <!-- end members field-->
                 <!-- start cat field-->
            <div class="row mb-1  input-wrapper status" >
            <label class="col-sm-2 lg ">Categories</label>
            <div class="col-sm-10 col-md-4">
            <select name="Categories" class="form-control">
                <option value='0'>...</option>
                <?php
                $stmt2=$connect->prepare("SELECT * FROM categories");
                $stmt2->execute();
                $cats=$stmt2->fetchAll();
                foreach($cats as $cat){
                echo"<option value='".$cat['id']."'";
                if($item['users_id'] == $cat['id']){echo 'selected';}
                echo">".$cat['name']."</option>";
                                        }
                ?>
            </select>
                    </div>
                </div> 
                <!-- end cat field-->
                  <!-- start submit field -->
            <div class="row mb-3">
            <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="add Item" class="btn btn-primary btn-sm">
                    </div>
                </div>
                <!-- end submit field -->
           </form>
           <?php
          
        $stmt=$connect->prepare("SELECT comments.*,users.username AS Member
                             FROM comments
                             INNER JOIN users
                             ON users.userid=comments.user_id 
                             WHERE item_id=?");
    $stmt->execute(array($itemid));
    $rows=$stmt->fetchALL();
    ?>
        <h1 class='text-center'>Manage <?php echo $item['name']?> comments</h1>
        <div class="container">
        <table class="table-responsive">
        <table class="main-table text-center table table-borderd">
                  <tr>
                       
                        <td>Comment</td>
                        <td>User name</td>
                        <td>Added Date</td>
                        <td>Control</td>
                  </tr>
                  <?php
                     foreach($rows as $row){
                        
                        echo "<tr>";
                        
                        echo "<td>".$row['comment']."</td>";
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
           <tr>    
        </table>
       
            </div>
                  
        </div>
            
       <?php }else{//else show error message if there is no such id
        echo"<div class='container'>";
        $msg="<div class='alert alert-danger'>There is no such id</div>";
        Redirecthome($msg,'back');
        echo"</div>";
                   }
    }elseif($do=='insert'){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
     echo "<h1 class='text-center'>Insert Items</h1>";
          echo"<div class='container'></div>";
   
    $name             =$_POST['name'];
    $desc             =$_POST['Describtion'];
    $price            =$_POST['price'];
    $country          =$_POST['country'];
    $status           =$_POST['status'];
    $Members          =$_POST['Members'];
    $Categories       =$_POST['Categories'];

  
    //validate the form
    $formerrors = array();
 if(empty($name)){$formerrors[]='Name can\'t <strong>empty</strong>';}
 if(empty($desc)){$formerrors[]='Describtion can\'t <strong>empty</strong>';}
 if(empty($price)){$formerrors[]='Price can\'t be <strong>empty</strong>';}
 if(empty($country)){$formerrors[]='country can\'t be <strong>empty</strong>';}
 if(empty($status)){$formerrors[]='You must choose the <strong>status</strong>';}
 if(empty($Members)){$formerrors[]='You must choose the <strong>member</strong>';}
 if(empty($Categories)){$formerrors[]='You must choose the <strong>category</strong>';}

 foreach($formerrors as $error){echo '<div class="alert alert-danger">'.$error.'</div>';}
 //update database with this info
 if(empty( $formerrors ) ){
           $stmt=$connect->prepare("INSERT INTO
                                        items(name,describtion,price,country_made,status,add_date,users_id,cat_id)
                                    VALUES(:Aname,:Adescribtion,:Aprice,:Acountry,:Astatus,now(),:Aid,:ACAT) ");
            $stmt->execute(array(
            'Aname'        => $name,
            'Adescribtion' => $desc,
            'Aprice'       => $price,
            'Acountry'     => $country,
            'Astatus'      =>  $status,
            'Aid'          =>  $Members,
            'ACAT'         =>  $Categories
           
                         )) ;                        
        $msg='<div class="alert alert-success">'.$stmt->rowCount().' Record inserted</div>';
        Redirecthome($msg);
                        }
}else{
   $msg='<div class="alert alert-danger">you can\'t browse this page directly</div>';
    Redirecthome($msg);
   
}
    }
    elseif($do=='update'){
         echo "<h1 class='text-center'>Update items</h1>";
          echo"<div class='container'>";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id               =$_POST['itemid'];
    $name             =$_POST['name'];
    $desc             =$_POST['Describtion'];
    $price            =$_POST['price'];
    $country          =$_POST['country'];
    $status           =$_POST['status'];
    $Members          =$_POST['Members'];
    $Categories       =$_POST['Categories'];
   
  
    //validate the form
     $formerrors = array();
 if(empty($name)){$formerrors[]='Name can\'t <strong>empty</strong>';}
 if(empty($desc)){$formerrors[]='Describtion can\'t <strong>empty</strong>';}
 if(empty($price)){$formerrors[]='Price can\'t be <strong>empty</strong>';}
 if(empty($country)){$formerrors[]='country can\'t be <strong>empty</strong>';}
 if(empty($status)){$formerrors[]='You must choose the <strong>status</strong>';}
 if(empty($Members)){$formerrors[]='You must choose the <strong>member</strong>';}
 if(empty($Categories)){$formerrors[]='You must choose the <strong>category</strong>';}
 foreach($formerrors as $error){echo '<div class="alert alert-danger">'.$error.'</div>';}
 //update database with this info
if (empty($formerrors)) {
    $stmt = $connect->prepare("UPDATE
                                  items
                               SET 
                                  name=?,
                                  describtion=?,
                                  price=?,
                                  country_made=?,
                                  status=?,
                                  users_id=?, 
                                  cat_id=?, 
                              WHERE 
                                 item_id=?");
    $stmt->execute(array($name, $desc, $price, $country, $status,$Members,$Categories,$id));
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
    }
    elseif($do=='delete'){
        echo "<h1 class='text-center'>Delete items</h1>";
    echo"<div class='container'>";
   //check if get request userid is numeric and get the interger value of it+
    $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
    //select all data depend on this id
    $check=checkitem('item_id','items',$itemid);
    
    if($check >0){
       $stmt=$connect->prepare("DELETE FROM items where item_id=:zitemid");
       $stmt->bindparam(":zitemid",$itemid);
       $stmt->execute();
       $msg='<div class="alert alert-success">'.$stmt->rowCount().' Record deleted</div>';
       Redirecthome($msg,'back');
}
else{
    $msg="<div class='alert alert-danger'>this id is not exist</div>";
    Redirecthome($msg,'back');
      }
      echo"</div>";
    }
    elseif($do=='Approve'){
    echo "<h1 class='text-center'>Approve item</h1>";
    echo"<div class='container'>";
   //check if get request userid is numeric and get the interger value of it+
    $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
    //select all data depend on this id
    $check=checkitem('item_id','items',$itemid);
    
    if($check >0){
       $stmt=$connect->prepare("UPDATE items set Approve=1 WHERE item_id=?");
     
       $stmt->execute(array($itemid));
       $msg='<div class="alert alert-success">'.$stmt->rowCount().' Record Approved</div>';
       Redirecthome($msg,'back');
}
else{
    $msg="<div class='alert alert-danger'>this id is not exist</div>";
    Redirecthome($msg,'back');
      }
      echo"</div>";  
    }
    
    if($do=='manage'){}
    include $tpl.'footer.php';
}else{
    header("index.php");
}
ob_end_flush();
?>