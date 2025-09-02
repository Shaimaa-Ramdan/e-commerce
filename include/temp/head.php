<!DOCTYPE html>
<head>
    <meta charset="utf-8"/>
    <title>
       <?php  gettitle()?>
    </title>
    <link rel="stylesheet" href="<?php echo $css?>bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo $css?>fontawesome.min.css"/>
    <link rel="stylesheet" href="<?php echo $css?>jquery-ui.css"/>
    <link rel="stylesheet" href="<?php echo $css?>jquery.selectBoxIt.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="<?php echo $css?>frontend.css"/>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" aria-current="page" href="index.php">HOME PAGE</a></li>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <!-- عناصر على الشمال -->
     <ul class="navbar-nav ms-auto navbar-item">
            <?php
            foreach(getcat() as $cat){
               echo '<li"><a href="categories.php?pageid='.$cat['id'].'&pagename='.str_replace('','-',$cat['name']).'">' . $cat['name'] . '</a></li>';

            }
            ?>
     </ul>

    </div>
  </div>
</nav>