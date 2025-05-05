<?php 
include('../config/constants.php');
//initialize variable
$showModal = false;
$modalMessage = '';
if($_SERVER['REQUEST_METHOD']=='POST')
{
  if(isset($_POST['submit'])){
  if(isset($_POST['username']) && isset($_POST['password'])){
  //get the data from registration form
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $raw_password = md5($_POST['password']);
  $password = mysqli_real_escape_string($conn, $raw_password);
  //check whether username and paasword exist or not
  $sql = "SELECT * FROM tbl_user WHERE username='$username' AND password='$password'";
  //execute the query
  $res = mysqli_query($conn,$sql);

  //count rows to check whether user exists or not 
  if(mysqli_num_rows($res)>0){
    $row = mysqli_fetch_assoc($res);
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $showModal = true;
    $_SESSION['modalMessage'] = "Login Successful";
    
  }
  else
  {
    $showModal = true;
    $_SESSION['modalMessage'] = "Incorrect Username or Password. Please try again!";
    
  }
 }
}
if(isset($_POST['okbutton'])){ 
  $modalMessage = $_SESSION['modalMessage'] ?? ''; 
    if ($modalMessage == "Login Successful"){
      unset($_SESSION['modalMessage']);
      header("Location: index.php");
      exit();
    }
    else{
      $showModal = false;
    }
  }
}
?>
<html>
    <head>
        <title>User Login - Book Corner</title>
        <link rel="stylesheet" href="../css/user.css">
    </head>
    <body style="background-image: url(../images/book.jpeg);">
    <br><b><h3 class="text-center text-beige " style="font-size: 21px;">Book Corner</h3></b>
         <div class="lgcontainer">
         <h2>Login</h2>

         <?php 
            if(isset($_SESSION['no-login-message']))
              {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
              }
          ?>
         <br>
             <!-- login form -->
             <form action="" method="POST">
                <div >Username: </div>
                <input type="text" name="username" placeholder="Enter Username" required>
                <br>
                <div>Password: </div>
                <input type="password" name="password" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="must contain one number one lowercase and uppercase letter,and atleast 8 or more character" required >
                <br>
                <button type="submit" name="submit" >Login</button>
                <p><a href="forgot-pwd.php">Forgot Password?</a></p>
                </form>
                <br>
                <p>Don't have an account? <a href="register.php">Register here</a></p>
                <br>
                <p>Created By - <a href="#">Nibah Kondvilkar</a></p>
          </div>
          <!-- to show the message -->
         <div class="modal <?php echo  $showModal ? 'show' : '';?>">
            <div class="modal-content">
            <p><?php echo htmlspecialchars($_SESSION['modalMessage']);?></p>
                <form action="" method="POST">
                    <button type="submit" name="okbutton" value="submit" >OK</button>
                </form>
            </div>
         </div>
    </body>
</html>