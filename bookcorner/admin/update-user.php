<?php include('partials/menu.php'); ?>

<div class="main-content text-center">
    <div class="wrapper">
        <h1>Update User</h1>
         <br>
         <?php 
            //1.get the id of selected user
            $id=$_GET['id'];

            //2.create sql query to get id detail
            $sql="SELECT * FROM tbl_user WHERE id = $id";
            
            //execute the query
            $res=mysqli_query($conn, $sql);

            //check whether the query is executed or not 
            if($res==true)
            {
                //check whether the data is available or not
                $count = mysqli_num_rows($res);
                //check whether we have user data or not 
                if($count==1)
                {
                  //get the detail
                   //echo "user available";
                  $row = mysqli_fetch_assoc($res);

                  $full_name = $row['full_name'];
                  $username = $row['username'];
                  $email = $row['email'];

                  //store original value to show what has been changed
                  $or_full_name = $full_name;
                  $or_username = $username;
                  $or_email = $email;
                }
                else
                {
                  //redirect to manage user page
                   header("location:".SITEURL.'admin/manage-user.php');
                }
            }
         
         ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name :</td>
                    <td> 
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>" required oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td> 
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td>
                        <input type="email" name="email" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" value="<?php echo $email;?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update user" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>
<?php
//include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
    //check whether the submit button is clicked or not 
    if(isset($_POST['submit']))
    {
        //echo "button clicked";
        //get all the values from form to update
        $id = $_POST['id'];
        $full_name = mysqli_real_escape_string ($conn,$_POST['full_name']);
        $username = mysqli_real_escape_string ($conn,$_POST['username']);
        $email = mysqli_real_escape_string ($conn,$_POST['email']);

        //create a sql query to update user
        $sql="UPDATE tbl_user SET
        full_name = '$full_name',
        username = '$username',
        email = '$email' 
        WHERE id = '$id'
        ";

        //execute the query 
        $res = mysqli_query($conn, $sql);

        //check if query is executed  or not
        if($res==true)
        {
            //query is executed and user is updated
            $_SESSION['update'] = "<div class='success'>User Updated Successfully</div>";

            //prepare message to notify user what has been updated
            $updatedFields ='';
            if($or_full_name != $full_name){
                $updatedFields .="Full Name: $or_full_name -> $full_name<br>";
            }
            if($or_username != $username){
                $updatedFields .="Username: $or_username -> $username";
            }
            if($or_email != $email){
                $updatedFields .="Email: $or_email -> $email";
            }

            //send the email to user
            $mail = new PHPMailer(true);
            
      try {
        // Server settings
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = 'kondvilkarnibah@gmail.com';  // my Gmail
        $mail->Password   = 'ubtw gyvu eneq pwhf';    // App Password
        $mail->SMTPSecure = 'tls';                                
        $mail->Port       = 587;                                  

        // Recipients
        $mail->setFrom('kondvilkarnibah@gmail.com', 'Book Store');
        $mail->addAddress($email, $full_name);        

        // Content
        $mail->isHTML(true);                                      
        $mail->Subject = 'Profile Update Notification';
        $mail->Body = "Hi $full_name,<br><br>Your profile has been updated. Here are the changes made:<br><br>$updatedFields<br><br>Best regards,<br>The Book Store Team";

        $mail->send();
        
      } catch (Exception $e) {
       // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
            //redirect to manage admin page 
            header("location:".SITEURL.'admin/manage-user.php');
        }
        else
        {
            //failed to update admin
            $_SESSION['update'] = "<div class='error'>Failed To Updated User</div>";
            //redirect to manage admin page 
            header("location:".SITEURL.'admin/manage-user.php');
        }
    }
?>

<?php include('partials/footer.php'); ?>