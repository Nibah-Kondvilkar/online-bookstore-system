<?php include('partials/menu.php'); ?>
    <div class="main-content text-center">
        <div class="wrapper">
          <h1>Add Admin</h1>
          <br><br/>

          <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
         ?>
        <form action="" method="POST" >

            <table class="tbl-30 ">
                <tr>
                    <td>Full Name: </td>
                    <td> 
                        <input type="text" name="full_name"  placeholder="Enter Your Name"  required oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td> 
                        <input type="text" name="username" placeholder="Enter Your Username" required>
                    </td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td> 
                        <input type="password" name="password" placeholder="Enter password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="must contain one number one lowercase and uppercase letter,and atleast 8 or more character" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>


<?php include('partials/footer.php'); ?>

<?php

   //process the value from form and save it in database 
   //check whether the submit button is clicked or not
   
   if(isset($_POST['submit']))
   {
    // button clicked
    //echo "Button clicked";

    //1.get data from form 
     $full_name = mysqli_real_escape_string ($conn, $_POST['full_name']);
     $username =mysqli_real_escape_string($conn, $_POST['username']);
     $raw_password = md5($_POST['password']);//md5 is used for encrption of password
     $password = mysqli_real_escape_string($conn, $raw_password);

    //2.SQL Query to save data into database
    $sql = "INSERT INTO tbl_admin SET
          full_name='$full_name',
          username='$username',
          password='$password'
    ";
    

    //3.executing query and saving data into database
    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    //4.check whether the(Query is executed ) data is inserted or not and display appropirate message
    if($res==TRUE)
    {
        //Data Inserted
        //echo "data inserted";
        //create a session variable to display message
        $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
        //redirect page to manage admin 
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else{
        //failed to insert data
        //echo "failed to insert data";
        //create a session variable to display message
        $_SESSION['add'] = "<div class='error'>Failed To Add Admin</div>";
        //redirect page to add admin 
        header("location:".SITEURL.'admin/add-admin.php');
    }

   }
 
?>  
        