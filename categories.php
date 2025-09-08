<?php

include "init.php";?>
<div class='container'>
    <h1 class='text-center'><?php echo $_GET['pagename']?></h1>
    <div class="row">
    <?php
   
    foreach(gettcat('cat_id',$_GET['pageid']) as $item){
  
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
           
    } 
    ?>
    
</div>
</div>


<?php include $tpl.'footer.php';