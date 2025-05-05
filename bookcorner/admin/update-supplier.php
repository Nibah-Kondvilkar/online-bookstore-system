<?php include('partials/menu.php'); 
ob_start();
?>

<div class="main-content text-center">
    <div class="wrapper">
        <h1>Update Supplier</h1>
        
         <br><br>
         <?php 
            //1.get the id of selected admin
            $id=$_GET['id'];

            //2.create sql query to get id detail
            $sql="SELECT * FROM tbl_supplier WHERE id = $id";
            
            //execute the query
            $res=mysqli_query($conn, $sql);

            //check whether the query is executed or not 
            if($res==true)
            {
                //check whether the data is available or not
                $count = mysqli_num_rows($res);
                //check whether we have admin data or not 
                if($count==1)
                {
                  //get the detail
                   //echo "admin available";
                  $row = mysqli_fetch_assoc($res);

                  $full_name = $row['full_name'];
                  $contact = $row['contact'];
                  $email = $row['email'];
                }
                else
                {
                  //redirect to manage admin page
                   header("location:".SITEURL.'admin/manage-supplier.php');
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
                    <td>Contact: </td>
                    <td> 
                    <input type="text" name="contact" pattern="[789][0-9]{9}" maxlength="10" placeholder="Enter Phone Number" class="input-responsive" required oninput="this.value = this.value.replace(/\D/g, ''); if (this.value.length === 1 && !/[789]/.test(this.value)) {
                this.value = '';}this.value = this.value.slice(0, 10);">
                    </td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td> 
                        <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Enter Email" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update Supplier" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>
<?php
    //check whether the submit button is clicked or not 
    if(isset($_POST['submit']))
    {
        //echo "button clicked";
        //get all the values from form to update
        $id = $_POST['id'];
        $full_name = mysqli_real_escape_string ($conn,$_POST['full_name']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        //create a sql query to update admin
        $sql="UPDATE tbl_supplier SET
        full_name = '$full_name',
        contact = '$contact',
        email='$email'
        WHERE id = '$id'
        ";

        //execute the query 
        $res = mysqli_query($conn, $sql);

        //check if query is executed  or not
        if($res==true)
        {
            //query is executed and admin is updated
            $_SESSION['update'] = "<div class='success'>Supplier Updated Successfully</div>";
            //redirect to manage admin page 
            header("location:".SITEURL.'admin/manage-supplier.php');
        }
        else
        {
            //failed to update admin
            $_SESSION['update'] = "<div class='error'>Failed To Updated Supplier</div>";
            //redirect to manage admin page 
            header("location:".SITEURL.'admin/manage-supplier.php');
        }
    }
?>



<?php include('partials/footer.php'); ?>