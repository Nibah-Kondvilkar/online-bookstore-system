<?php
    //include constants.php file here
    include('../config/constants.php');

    //1.get the id of admin to be deleted 
    $id = $_GET['id'];

    //2.create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //execute the query 
    $res = mysqli_query($conn, $sql);

    //check whether the query executed successfully 
    if($res==true)
    {
        //query executed successfully and admin deleted 
        //echo "admin deleted";
        //create session variable to display message 
        $_SESSION['delete'] = "<div class='success'> Admin Deleted Successfully</div>";
        //rediect to manage admin page 
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //failed to delete admin 
        //echo "failed to delette admin ";
        $_SESSION['delete'] = "<div class='error'>Failed To Delete Admin</div> ";
        header('location:'.SITEURL.'admin/manage-admin.php');

    }

?>