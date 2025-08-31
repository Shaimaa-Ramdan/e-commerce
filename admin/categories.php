<?php
/*
===================================================
==manage categories page 
==you can add edit delete
===================================================
*/
ob_start();
session_start();
$pagetitle="Categories";
if(isset($_SESSION['username'])){
include 'init.php';
 $do=isset($_GET['do'])?$_GET['do']:'manage';
if($do =='manage'){
    global $connect;
    $sort="DESC";
    $sort_array=array('ASC','DESC');
    if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
        $sort=$_GET['sort'];
    }
    $stmt=$connect->prepare("SELECT * FROM categories ORDER BY ordering $sort");
    $stmt->execute();
    $cats=$stmt->fetchall();
    if(!empty($cats)){?>
    <h1 class='text-center'>Manage Page</h1>
    <div class='container categories'>
        <div class='card card-default'>
            <div class='card card-header'><i class="fa fa-edit"></i>Manage category
                    <div class='option'><i class="fa fa-sort"></i>Ordering:[
                        <a class="<?php if($sort == 'ASC'){echo 'active';}?>" href='?sort=ASC' >ASC</a>
                        <a class="<?php if ($sort=='DESC'){echo 'active';}?>"href='?sort=DESC'>DESC</a>]
                        <i class="fa fa-eye"></i>View:[
                        <span class='active' data-view='full'>full-view</span>
                        <span data-view='classic'>classic</span>]
                    </div>
                  
             </div>
             <?php
            echo"<div class='card card-body'>";
             foreach($cats as $cat){
                 echo "<div class='cat'>";
                echo'<div class="button-hidden">';
                echo"<a href='categories.php?do=Edit&catid=".$cat['id']."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                echo"<a href='categories.php?do=delete&catid=".$cat['id']."' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                echo'</div>';
                echo"<h3>".$cat['name']."</h3>";
                echo"<div class='full-view'>";
                echo'<p>';
                 echo empty($cat['describtion']) ? 'This category has no describtion': $cat['describtion'];
                        echo'</p>';
                        if($cat['visibility'] == 1){echo '<span class="visibility"><i class="fa fa-eye"></i>Hidden  </span>';}
                        if($cat['allow_comments'] == 1){echo '<span class="commenting"><i class="fa fa-close"></i>Comment disabled  </span>';}
                        if($cat['allow_ads'] == 1){echo '<span class="advertise"><i class="fa fa-close"></i>Ads disabled</span>';}
                echo"</div>";
                 echo "</div>";
                 }
            echo"</div>";
        echo"</div>";?>
          <a class="add-category btn btn-primary" href="categories.php?do=add"><i class="fa fa-add"></i>Add Category</a>
          <?php
    echo"</div>";
                }else{
                    echo'<div class="alert alert-danger">There is no category to show</div>';
                   echo'<a class="add-category btn btn-primary" href="categories.php?do=add"><i class="fa fa-add"></i>Add Category</a>';
                }
    ?>
  
    <?php

 } elseif($do =='add'){?>
<h1 class="text-center">Add Categories</h1>
            <div class="container">
        <form action="?do=insert" method="POST">
            <input type="hidden" name="userid">
            <!-- start name field-->
            <div class="row mb-1 form-control-lg input-wrapper" >
            <label class="col-sm-2 lg">Name</label>
            <div class="col-sm-10 col-md-4">
            <input type="text" name="name" class="form-control "autocomplete="off" required="required" 
            placeholder="Name of the categroy">
                    </div>
                </div>
                <!-- end name field -->
                    <!-- start DESCRIBTION field -->
            <div class="row mb-3 form-control-lg input-wrapper" >
            <label class="col-sm-2 con-form-label">Describtion</label>
            <div class="col-sm-10 col-md-4">
            <input type="text" name="describtion" class="form-control "placeholder="describe your category">
                    </div>
                </div>
                <!-- end DESCRIBTION field -->
                    <!-- start ordering field -->
            <div class="row mb-3 form-control-lg input-wrapper">
            <label class="col-sm-2 con-form-label">Ordering</label>
            <div class="col-sm-10 col-md-4">
            <input type="text" name="ordering"  class="form-control"autocomplete="off" placeholder="Number to arrange the category">
                    </div>
                </div>
                <!-- end ordering field -->
                    <!-- start visibility field -->
            <div class="row mb-3 form-control-lg">
            <label class="col-sm-2 con-form-label">Visibile</label>
                    <div class="col-sm-10 col-md-4">
                        <input id='vis-yes' type="radio" name="visibility"value="0"checked>
                        <label for="vis-yes">YES</label>
                    </div>
                    <div class="col-sm-10 col-md-4">
                        <input id='vis-no' type="radio" name="visibility"value="1">
                        <label for="vis-no">NO</label>
                    </div>
            </div>
                <!-- end visibility field -->
                   <!-- start commenting field -->
            <div class="row mb-3 form-control-lg">
            <label class="col-sm-2 con-form-label">Allow commenting</label>
                    <div class="col-sm-10 col-md-4">
                        <input id='comm-yes' type="radio" name="commenting"value="0"checked>
                        <label for="comm-yes">YES</label>
                    </div>
                    <div class="col-sm-10 col-md-4">
                        <input id='comm-no' type="radio" name="commenting"value="1">
                        <label for="comm-no">NO</label>
                    </div>
            </div>
                <!-- end commenting field -->
                 <!-- start ads field -->
            <div class="row mb-3 form-control-lg">
            <label class="col-sm-2 con-form-label">Allow ads</label>
                    <div class="col-sm-10 col-md-4">
                        <input id='ads-yes' type="radio" name="ads"value="0"checked>
                        <label for="ads-yes">YES</label>
                    </div>
                    <div class="col-sm-10 col-md-4">
                        <input id='ads-no' type="radio" name="ads"value="1">
                        <label for="ads-no">NO</label>
                    </div>
            </div>
                <!-- end visibility field -->
                 <!-- start submit field -->
            <div class="row mb-3">
            <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="add categroy" class="btn btn-primary btn-lg">
                    </div>
                </div>
                <!-- end submit field -->
        </form>
        </div>
    
<?php }elseif($do=="insert"){ 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
     echo "<h1 class='text-center'>Insert category</h1>";
     echo"<div class='container'></div>";
    $name   =$_POST['name'];
    $desc   =$_POST['describtion'];
    $order  =$_POST['ordering'];
    $vis    =$_POST['visibility'];
    $comm   =$_POST['commenting'];
    $ads    =$_POST['ads'];
    //check if  exist category in database
    $check=Checkitem("name","categories",$name);
    if($check==1){
    $msg="<div class='alert alert-danger'>sorry this category exist in database</div>";
    Redirecthome($msg,'back');
           }else{
            $stmt=$connect->prepare("INSERT INTO
                                        categories(name,describtion,ordering,visibility,allow_comments,allow_ads)
                                    VALUES(:Aname,:Adescribtion,:Aordering,:Avisibility,:Aallow_comments,:Aallow_ads) ");
            $stmt->execute(array(
            'Aname' => $name,
            'Adescribtion' => $desc,
            'Aordering' => $order,
            'Avisibility' => $vis,
            'Aallow_comments' => $comm,
            'Aallow_ads' => $ads

            )) ;                        
        $msg='<div class="alert alert-success">'.$stmt->rowCount().' Record inserted</div>';
        Redirecthome($msg,'back');
        }}
   else{
    echo"<div class='continer'>";
    $msg="<div class='alert alert-danger'>sorry you can/'t browse this page directly</div>";
    Redirecthome($msg);
    echo"</div>";
}
echo"</div>";
}elseif($do =='Edit'){
     //check if get request catid is numeric and get the interger value of it+
    $catid=isset($_GET['catid']) && is_numeric($_GET['catid'])?intval($_GET['catid']):0;
    //select all data depend on this id
    $stmt=$connect->prepare("SELECT * from categories where id=? ");
    //execute quary
    $stmt->execute(array($catid));
    //fetch data
    $cat=$stmt->fetch();
    //row count
    $count=$stmt->rowCount();
   
    if($count > 0){?>
        <h1 class="text-center">Edit Categories</h1>
            <div class="container">
        <form action="?do=update" method="POST">
            <input type="hidden" name="catid" value="<?php echo  $catid?>"/>
            <!-- start name field-->
            <div class="row mb-1 form-control-lg input-wrapper" >
            <label class="col-sm-2 lg">Name</label>
            <div class="col-sm-10 col-md-4">
            <input type="text" name="name" class="form-control " required="required" 
            placeholder="Name of the categroy" value="<?php  echo$cat['name']?>">
                    </div>
                </div>
                <!-- end name field -->
                    <!-- start DESCRIBTION field -->
            <div class="row mb-3 form-control-lg input-wrapper" >
            <label class="col-sm-2 con-form-label">Describtion</label>
            <div class="col-sm-10 col-md-4">
            <input type="text" name="describtion" class="form-control "placeholder="describe your category" value="<?php  echo$cat['describtion']?>">
                    </div>
                </div>
                <!-- end DESCRIBTION field -->
                    <!-- start ordering field -->
            <div class="row mb-3 form-control-lg input-wrapper">
            <label class="col-sm-2 con-form-label">Ordering</label>
            <div class="col-sm-10 col-md-4">
            <input type="text" name="ordering"  class="form-control"autocomplete="off" placeholder="Number to arrange the category"value="<?php  echo$cat['ordering']?>">
                    </div>
                </div>
                <!-- end ordering field -->
                    <!-- start visibility field -->
            <div class="row mb-3 form-control-lg">
            <label class="col-sm-2 con-form-label">Visibile</label>
                    <div class="col-sm-10 col-md-4">
                        <input id='vis-yes' type="radio" name="visibility"value="0" <?php if($cat['visibility']==0){echo 'checked';} ?>>
                        <label for="vis-yes">YES</label>
                    </div>
                    <div class="col-sm-10 col-md-4">
                        <input id='vis-no' type="radio" name="visibility"value="1" <?php if($cat['visibility']==1){echo 'checked';} ?>>
                        <label for="vis-no">NO</label>
                    </div>
            </div>
                <!-- end visibility field -->
                   <!-- start commenting field -->
            <div class="row mb-3 form-control-lg">
            <label class="col-sm-2 con-form-label">Allow commenting</label>
                    <div class="col-sm-10 col-md-4">
                        <input id='comm-yes' type="radio" name="commenting"value="0" <?php if($cat['allow_comments']==0){echo 'checked';} ?>>
                        <label for="comm-yes">YES</label>
                    </div>
                    <div class="col-sm-10 col-md-4">
                        <input id='comm-no' type="radio" name="commenting"value="1" <?php if($cat['allow_comments']==1){echo 'checked';} ?>>
                        <label for="comm-no">NO</label>
                    </div>
            </div>
                <!-- end commenting field -->
                 <!-- start ads field -->
            <div class="row mb-3 form-control-lg">
            <label class="col-sm-2 con-form-label">Allow ads</label>
                    <div class="col-sm-10 col-md-4">
                        <input id='ads-yes' type="radio" name="ads"value="0"<?php if($cat['allow_ads']==0){echo 'checked';} ?>>
                        <label for="ads-yes">YES</label>
                    </div>
                    <div class="col-sm-10 col-md-4">
                        <input id='ads-no' type="radio" name="ads"value="1" <?php if($cat['allow_ads']==1){echo 'checked';} ?>>
                        <label for="ads-no">NO</label>
                    </div>
            </div>
                <!-- end visibility field -->
                 <!-- start submit field -->
            <div class="row mb-3">
            <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="Save" class="btn btn-primary btn-lg">
                    </div>
                </div>
                <!-- end submit field -->
        </form>
        </div>
    
<?php 
    }
           
}elseif($do =="update"){
     echo "<h1 class='text-center'>Update Category</h1>";
          echo"<div class='container'>";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
   $id     =$_POST['catid'];
    $name   =$_POST['name'];
    $desc  =$_POST['describtion'];
    $order   =$_POST['ordering'];
    $vis   =$_POST['visibility'];
    $comment   =$_POST['commenting'];
    $ads   =$_POST['ads'];
 
    $stmt = $connect->prepare("UPDATE categories SET name=?, describtion=?, ordering=?, visibility=?, allow_comments=?, allow_ads=?WHERE id=?");
    $stmt->execute([$name, $desc, $order, $vis, $comment,$ads,$id]);

    $msg='<div class="alert alert-success">'.$stmt->rowCount().'record updated</div>';
    Redirecthome($msg,'back',4);


}else{
    echo"<div class='continer'>";
    $msg="<div class='alert alert-danger'>sorry you can/'t browse this page directly</div>";
    Redirecthome($msg);
    echo"</div>";
}
 echo'</div>';
}elseif($do == 'delete'){
echo"<h1 class='text-center'>Delete Category</h1>";
echo"<div class='container'>";
$catid=isset($_GET['catid'])&&is_numeric($_GET['catid']) ?$_GET['catid']:0;
$check=checkitem('id','categories',$catid);
if($check >0){
    $stmt=$connect->prepare("DELETE FROM categories WHERE id=:zid");
    $stmt->bindparam('zid',$catid);
    $stmt->execute();
     $msg='<div class="alert alert-success">'.$stmt->rowCount().' Record deleted</div>';
       Redirecthome($msg,'back');

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