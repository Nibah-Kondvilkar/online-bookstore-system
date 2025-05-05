<?php include('../config/constants.php');?>

<html>
    <head>
        <title>Login - Book Corner</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body style="background-image: url(../images/book.jpeg);">
        <section class="search ">
         <div class="container">
         <div class="text-center text-beige" > <b><h3>Book Corner</h3></b></div>
           <fieldset class="lgcontainer">
           <legend class="text-center"><b>Login</b></legend>
             

             <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset ($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
             ?>
             <br>

             <!-- login form -->
             <form action="" method="POST" class="text-center label1">
                <div class="label">Username: </div>
                <input type="text" name="username" placeholder="Enter Username" required class="input-responsive" >
                <br><br>
                <div class="label">Password: </div>
                <input type="password" name="password" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="must contain one number one lowercase and uppercase letter,and atleast 8 or more character" required class="input-responsive">
                <br><br>
                <button type="submit" name="submit" value="Login" class="btn-login">Login</button>
                <br><br>
                <p >Created By - <a href="#">Nibah Kondvilkar</a></p>
                
            </fieldset>
            </form>
          </div>
        </section>
    </body>
</html>

<?php
   //check whether the submit button is clicked or not 
   if(isset($_POST['submit']))
   {
    //process the login 
    //1.get the data from login form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $raw_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $raw_password);

    //2.sql to check whether the user with username or password exists or not
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    //3.execute the query 
    $res = mysqli_query($conn, $sql);
    
    //4.count rows to check whether user exists or not 
    $count = mysqli_num_rows($res);

    if($count==1)
    {
      //user exist and login success
      $_SESSION['login'] = "<div class='success'>Login Successfull</div>";
      $_SESSION['user'] = $username;//to check whether the user is login in or not and logout.php will unset it
      //redirect to home page
      header('location:'.SITEURL.'admin/');

    }
    else
    {
        //user not available and login failed
        $_SESSION['login'] = "<div class='error text-center'>Username And Password Did Not Match </div>";
        //redirect to home page
        header('location:'.SITEURL.'admin/login.php');
    }

   }

?>