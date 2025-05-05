<?php 
include('../config/constants.php');
// Include your PHPMailer files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
//initialize variable
$showModal = false;
$modalMessage = '';

function sendEmail($recipientEmail, $recipientName) {
  $mail = new PHPMailer(true);

  try {
      // Server settings
      $mail->isSMTP();                                          
      $mail->Host       = 'smtp.gmail.com';                     
      $mail->SMTPAuth   = true;                                 
      $mail->Username   = 'your email';  // my Gmail
      $mail->Password   = 'pass';    // App Password
      $mail->SMTPSecure = 'tls';                                
      $mail->Port       = 587;                                  

      // Recipients
      $mail->setFrom('email', 'Book Corner');
      $mail->addAddress($recipientEmail, $recipientName);        

      // Content
      $mail->isHTML(true);                                      
      $mail->Subject = 'Welcome to Book Corner!';
      $mail->Body    = "Hi $recipientName,<br><br>Thank you for registering with Book Corner! We're excited to have you.<br><br>Best regards,<br>The Book Corner Team";

      $mail->send();
      return true;
  } catch (Exception $e) {
     // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      return false;
  }
}

//check if username is begin checked
if(isset($_POST['check_username'])){
  $username = mysqli_real_escape_string($conn, $_POST['username']);

  //query to check if the username exists in the database
  $sql2 = "SELECT * FROM tbl_user WHERE username='$username'";
  $res2 = mysqli_query($conn, $sql2);

  if(mysqli_num_rows($res2)>0){
    //username is taken
    echo "taken";
  }else{
    //username is available
    echo "available";
  }
  exit;
}


if($_SERVER['REQUEST_METHOD']=='POST' && !isset($_POST['check_username']))
    {
    //1.get data from form 
    $full_name = mysqli_real_escape_string ($conn, $_POST['full_name']);
    $username =mysqli_real_escape_string($conn, $_POST['username']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']); 
    $raw_password = md5($_POST['password']);//md5 is used for encrption of password
    $password = mysqli_real_escape_string($conn, $raw_password);
    

    //validate input
    if(!empty($full_name) && !empty($username)){
   //2.SQL Query to save data into database
   $sql = "INSERT INTO tbl_user SET
         full_name='$full_name',
         username='$username',
         contact = '$contact',
         email='$email',
         address = '$address',
         password='$password'
   ";
   
     //executing the query and cheching whether data is inserted or not
     if(mysqli_query($conn, $sql)) {
      // Send a registration email
      if(sendEmail($email, $full_name)) {
          $modalMessage = "Registration Successful! A confirmation email has been sent.";
      } else {
          $modalMessage = "Registration Successful, but the confirmation email could not be sent.";
      }
      $showModal = true;
  } else {
      $modalMessage = "Registration failed. Please try again!";
      $showModal = true;
  }
} else {
  $modalMessage = "All fields are required!";
  $showModal = true;
}
}
    if (isset($_POST['ok_button'])){
        if ($modalMessage = "Registration Successfull!!"){
          header("Location: login.php");
          exit();
        }
        else{
          $showModal = false;
        }
      }

?>

<html>
    <head>
        <title>User Register - Book Corner</title>
        <link rel="stylesheet" href="../css/user.css">
        <script>
          function checkUsername(){
            console.log("checkUsername function called");
            const username = document.querySelector('input[name="username"]').value;
            const xhr = new XMLHttpRequest();

            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function(){
              if(this.readyState === XMLHttpRequest.DONE && this.status === 200){
                const response = this.responseText;
                const usernameField =document.querySelector('input[name="username"]');
                const usernameError = document.getElementById('username-error');

                if(response === "taken"){
                  usernameError.textContent = "This username is already taken, please choose another one.";
                  usernameField.setCustomValidity("This username is already taken, please choose another one.");
                }else{
                  usernameError.textContent = "";
                  usernameField.setCustomValidity("");
                }
              }
            };
            xhr.send("check_username=1&username=" + encodeURIComponent(username));
          }
        </script>
    </head>
    <body style="background-image: url(../images/book.jpeg);">
         <div class="lgcontainer">
          <h2>Register</h2>
          
          <!-- register form -->
          <form action="" method="POST">
                <div>Full Name: </div>
                <input type="text" name="full_name" placeholder="Enter Full Name" required  oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                
                <div>Username: </div>
                <input type="text" name="username" placeholder="Enter Username" required oninput="checkUsername()">
                <div id="username-error" style="color:red; font-size:0.9em;"></div>
              
                <div>Phone Number: </div>
                <input type="text" name="contact" pattern="[789][0-9]{9}" maxlength="10" placeholder="Enter Phone Number" class="input-responsive" required oninput="this.value = this.value.replace(/\D/g, ''); if (this.value.length === 1 && !/[789]/.test(this.value)) {
                this.value = '';}this.value = this.value.slice(0, 10);">
                
                <div>Email: </div>
                <input type="email" name="email" placeholder="Enter Email" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$"  required  >
                
                <div>Address: </div>
                <textarea name="address" rows="3" placeholder="Enter Address" class="input-responsive" required></textarea>
                
                <div >Password: </div>
                <input type="password" name="password" placeholder="Enter Password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="must contain one number one lowercase and uppercase letter,and atleast 8 or more character" required >
                <br>
                <button type="submit" name="submit" >Register</button>
          </form>
           <p>Already have an account? <a href="login.php">Login here</a></p>
         </div>
         <!-- to show the message -->
         <div class="modal <?php echo isset($_POST['submit']) && $showModal ? 'show' : '';?>">
            <div class="modal-content">
                <p><?php echo isset($modalMessage) ? $modalMessage: '';?></p>
                <form action="register.php" method="POST">
                    <button type="submit" name="ok_button">OK</button>
                </form>
            </div>
         </div>
   </body>
</html>

