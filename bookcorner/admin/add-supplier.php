<?php include('partials/menu.php'); 
ob_start();
?>
    <div class="main-content text-center">
        <div class="wrapper">
          <h1>Add Supplier</h1>
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
                        <input type="text" name="full_name"  placeholder="Enter Name"  required oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                    </td>
                </tr>
                
                <tr>
                    <td>Contact: </td>
                    <td> 
                    <input type="text" name="contact" pattern="[789][0-9]{9}" maxlength="10" placeholder="Enter Phone Number" class="input-responsive" required oninput="this.value = this.value.replace(/\D/g, ''); if (this.value.length === 1 && !/[789]/.test(this.value)) {
                    this.value = '';}this.value = this.value.slice(0, 10);">
                    </td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td> 
                        <input type="email" name="email" placeholder="Enter Email" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" required>
                    </td>
                </tr>
                <tr>
                    <td>Address: </td>
                    <td> 
                        <textarea name="address" rows="3" placeholder="Enter Address"  required></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Supplier" class="btn-secondary">
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
     $contact = mysqli_real_escape_string($conn, $_POST['contact']);
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $address =mysqli_real_escape_string($conn, $_POST['address']);

    //2.SQL Query to save data into database
    $sql = "INSERT INTO tbl_supplier SET
          full_name='$full_name',
          contact = '$contact',
          email='$email',
          address='$address'
    ";
    

    //3.executing query and saving data into database
    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    //4.check whether the(Query is executed ) data is inserted or not and display appropirate message
    if($res==TRUE)
    {
        //Data Inserted
        //echo "data inserted";
        //create a session variable to display message
        $_SESSION['add'] = "<div class='success'>Supplier Added Successfully</div>";
        //redirect page to manage admin 
        header("location:".SITEURL.'admin/manage-supplier.php');
    }
    else{
        //failed to insert data
        //echo "failed to insert data";
        //create a session variable to display message
        $_SESSION['add'] = "<div class='error'>Failed To Add Supplier</div>";
        //redirect page to add admin 
        header("location:".SITEURL.'admin/add-supplier.php');
    }

   }

?>