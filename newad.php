<?php
session_start();
$pagetitle='Create new item';
include "init.php";
if(isset($_SESSION['user'])){
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $formerror=array();
        $name=strip_tags($_POST['name']);
        $desc=strip_tags($_POST['Describtion']);
        $price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
        $country=strip_tags($_POST['country']);
        $status=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
        $categories=filter_var($_POST['Categories'],FILTER_SANITIZE_NUMBER_INT);
        if(empty($name)){$formerror[]='Item title must\'t be <strong>empty</strong>'; }
        if(empty($desc)){$formerror[]='Describtion must\'t be <strong>empty</strong>'; }
        if(empty($country)){$formerror[]='country must\'t be <strong>empty</strong>'; }
        if(empty($price)){$formerror[]='price must\'t be <strong>empty</strong>'; }
        if(empty($status)){$formerror[]='You must choose the <strong>status</strong>'; }
        if(empty($categories)){$formerror[]='You must choose the <strong>category</strong>'; }
        if (empty($formerror)){
               $stmt=$connect->prepare("INSERT INTO
                                        items(name,describtion,price,country_made,status,add_date,users_id,cat_id)
                                    VALUES(:Aname,:Adescribtion,:Aprice,:Acountry,:Astatus,now(),:Aid,:ACAT) ");
            $stmt->execute(array(
            'Aname'        => $name,
            'Adescribtion' => $desc,
            'Aprice'       => $price,
            'Acountry'     => $country,
            'Astatus'      =>  $status,
            'Aid'          =>  $_SESSION['uID'],
            'ACAT'         =>  $categories
           
                         )) ;   
                if($stmt){
                    echo 'Item added';
                }           
            }

}
    
?>
<h1 class='text-center'><?php echo $pagetitle?></h1>
<div class='new-ad block'>
    <div class='container'>
        <div class='card card-primary'>
            <div class='card card-header'><?php echo $pagetitle?></div>
            <div class='card card-body'>
              <div class="row">
                <div class="col-sm-8">
                     
                    <div class="container">
                        <form class='main-form' action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                        <input type="hidden" name="userid">
                        <!-- start name field-->
                        <div class="row mb-1 form-control-lg input-wrapper" >
                        <label class="col-sm-2 lg">Item</label>
                        <div class="col-sm-10 col-md-9">
                        <input type="text"
                            name="name"
                            class="form-control live"
                            required="required"
                            autocomplete="off"
                            data-class=".live-title"
                            placeholder="Name of the Item">
                                </div>
                            </div> 
                            <!-- end name field-->
                            <!-- start describtion field-->
                        <div class="row mb-1 form-control-lg input-wrapper" >
                        <label class="col-sm-2 lg">Describtion</label>
                        <div class="col-sm-10 col-md-9">
                        <input type="text"
                            name="Describtion"
                            class="form-control live"
                             required="required"
                            autocomplete="off" 
                            data-class=".live-desc" 
                            placeholder="Describtion of the Item">
                                </div>
                            </div> 
                            <!-- end Describtion field-->
                            <!-- start price field-->
                        <div class="row mb-1 form-control-lg input-wrapper" >
                        <label class="col-sm-2 lg">price</label>
                        <div class="col-sm-10 col-md-9">
                        <input type="text"
                            name="price"
                            class="form-control live"
                             required="required"
                            autocomplete="off"
                            data-class=".live-price"   
                            placeholder="price of the Item">
                                </div>
                            </div> 
                            <!-- end price field-->
                            <!-- start country field-->
                        <div class="row mb-1 form-control-lg input-wrapper" >
                        <label class="col-sm-2 lg">country</label>
                        <div class="col-sm-10 col-md-9">
                        <input type="text"
                            name="country"
                            class="form-control "
                            required="required"
                            autocomplete="off" 
                            placeholder="country of the Item">
                                </div>
                            </div> 
                            <!-- end country field-->
                            <!-- start status field-->
                        <div class="row mb-1  input-wrapper status" >
                        <label class="col-sm-2 lg ">Status</label>
                        <div class="col-sm-10 col-md-8">
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
                            
                            <!-- start cat field-->
                        <div class="row mb-1  input-wrapper status" >
                        <label class="col-sm-2 lg ">Categories</label>
                        <div class="col-sm-10 col-md-8">
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
                            </div>
                <div class="col-sm-4">
                    <div class="col-sm-6 col-md-4">
                    <div class="thumbnail live-preview">
                    <span class="price-tag e">
                        $<span class='live-price'></span>
                    </span>
                    <img class="img-responsive" src="data/upload/microphone.jpg" alt="microphone" weight="250px" height="300px">
                    <div class="caption">
                    <h3 class="itemm live-title">Title<h3>
                    <p class="live-desc">Describtion</p>
                    </div>
                    </div>       
                    </div>
                </div>
                <?php
                //statr looping error 
                if(!empty($formerror)){
                    foreach($formerror as $error){
                        echo'<div class="alert alert-danger">'.$error.'</div>';
                    }
                }
               
                //end looping error 
                ?>
              </div> 
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