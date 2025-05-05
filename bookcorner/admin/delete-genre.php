<?php
     include('../config/constants.php');
    //check whether the id  value is set or not
    if(isset($_GET['id']))
    {
        //get value and delete
        $id = $_GET['id'];

        //delete data from database
        $sql = "DELETE FROM tbl_genre WHERE id=$id";
        //execute the query
        $res = mysqli_query($conn,$sql);

        //check whether the data is deleted from database or not
        if($res==true)
        {
            //set success message and redirect
            $_SESSION['delete'] = "<div class='success'>Genre Deleted Successfully</div>";
            //redirect to manage category page with message 
            header('location:'.SITEURL.'admin/manage-genre.php');
        }
        else
        {
            //set error message and redirect
            $_SESSION['delete'] = "<div class='error'>Failed To Deleted Genre</div>";
            //redirect to manage category page with message 
            header('location:'.SITEURL.'admin/manage-genre.php');
        }
    }
    else
    {
        //redirect to manage category page
        header('location:'.SITEURL.'admin/manage-genre.php');
    }
?>