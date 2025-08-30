<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" aria-current="page" href="dashboard.php"><?php echo langs("HOME-ADMIN")?></a></li>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <!-- عناصر على الشمال -->
      <ul class="navbar-nav">
        
        <li class="nav-item"><a class="nav-link categories-link" href="categories.php"><?php echo langs("CATEGORIES")?></a></li>
        <li class="nav-item"><a class="nav-link categories-link" href="items.php"><?php echo langs("ITEMS")?></a></li>
        <li class="nav-item"><a class="nav-link categories-link" href="users.php"><?php echo langs("MEMBERS")?></a></li>
        <li class="nav-item"><a class="nav-link categories-link" href="comments.php"><?php echo langs("COMMENTS")?></a></li>
        <li class="nav-item"><a class="nav-link categories-link" href="#"><?php echo langs("STATISTICS")?></a></li>
        <li class="nav-item"><a class="nav-link categories-link" href="#"><?php echo langs("LOGS")?></a></li>
      </ul>

      <!-- عنصر dropdown على اليمين -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item  dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            Shaimaa
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="users.php?do=edit&userid=<?php echo $_SESSION['userid']?>">Edit Profile</a></li>
            <li><a class="dropdown-item" href="#">Setting</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>