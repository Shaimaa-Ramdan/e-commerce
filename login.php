<?php
ob_start();
session_start();
$pagetitle='login';
if(isset($_SESSION['user'])){
    header('location:index.php');
}
include "init.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['login'])){
    $user      = $_POST['username'];
    $pass      = $_POST['password'];
    $hashedpass = sha1( $pass);
   
    //check if user exist in database
    $stmt= $connect->prepare("SELECT 
                                     username,password
                               FROM 
                                     users     
                                WHERE      
                                      username=? 
                                AND 
                                    password=? 
                                 ");
    $stmt->execute(array($user,$hashedpass));
    $count=$stmt->rowCount();
    if($count>0){
        $_SESSION['user']=$user;
        header('location:index.php');
        
            }
 }else{
    $username   =$_POST['username'];
    $password1  =$_POST['password'];
    $password2  =$_POST['password2'];
    $email      =$_POST['email'];
    $formErrors =array();
    if (isset($username)) {

				$filterdUser =htmlspecialchars($username, ENT_QUOTES, 'UTF-8');

				if (strlen($filterdUser) < 4) {

					$formErrors[] = 'Username Must Be Larger Than 4 Characters';

				}

			}
    if(isset($password1) && isset( $password2)){
        if(empty($password1)){
            $formErrors[]='Password must\'t be empty';
        }
        $pass1=sha1($password1);
        $pass2=sha1($password2);
        if($pass1 !== $pass2){
            $formErrors[]='Sorry password is\'t match ';
        }

    }
    if(isset($email)){
        $filteremail=filter_var($email,FILTER_SANITIZE_EMAIL);
        if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) != true){
           $formErrors[]='This email must be valid';
        }
    }
    //update database with this info
 if(empty($formErrors) ){
    //check if user exist in database
    $check=Checkitem("username","users",$username);
    if($check==1){
    $formErrors="<div class='alert alert-danger'>sorry this username exist in database</div>";
    
    }else{
            $stmt=$connect->prepare("INSERT INTO
                                        users(username,password,email,regesterstatus,date)
                                    VALUES(:Ausername,:Apassword,:Aemail,0,now()) ");
            $stmt->execute(array(
            'Ausername'     => $username,
            'Apassword'     => sha1($password1),
            'Aemail'        => $email,

            )) ; 
            $successmeg='Congrats you are now registered';
  }
}
 }}
?>
<div>
    <img src="data/upload/logiin.jpg" alt="" width="850px" height="1000px">
      <div class="container login-form" >
        <h1 class="text-center"><span data-class="login" class="selected">Login|</span><span data-class="signup">Signup</span></h1>
        <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
           <input
               type="text"
               name="username"
               autocomplete="off"
               placeholder="Type your username">
           <input 
               type="password"
               name="password"
               autocomplete="new-password"
               placeholder="Type your password">
           <input 
               class="btn btn-primary btnn"
               type="submit"
               name="login" 
               value="login" >
        </form>
        <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
           <input 
               pattern=".{3,}" 
               title="username must be more than 3 chars"
               type="text"
               name="username"
               autocomplete="off"
               placeholder="Type your username">
           <input 
               minlength="4"
               type="password"
               name="password"
               autocomplete="new-password"
               placeholder="Type your complex password">
          <input 
               minlength="4"
               type="password"
               name="password2"
               autocomplete="new-password"
               placeholder="Type the password again">
            <input 
               type="email"
               name="email"
               placeholder="Type your valid email">
           <input 
               class="btn btn-success btnn"
               type="submit"
               name="signup" 
               value="signup" >
        </form>

      </div>
    </div>
    <div class='form-errors text-center'>
    <?php
    if(!empty($formErrors)){
        foreach($formErrors as $errors){
            echo $errors.'<br>';
        }
    }
    if(isset($successmeg)){
        echo '<div class="success-msg">'.$successmeg.'</div>';
    }
    ?>
</div>
</div>
<?php 
include  $tpl.'footer.php';
ob_end_flush();
?>