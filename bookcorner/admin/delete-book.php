<?php
include('../config/constants.php');
    
    
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //process to delete
        
        //1.get id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2.remove to image if available
        //check whether the image is available or not and delete only if available
        if($image_name!="")
        {
            //it has image and need to remove from folder
            //get the image path
            $path = "../images/book/".$image_name;

            //remove image file from folder
            $remove = unlink($path);

            //check whether the image is removed or not 
            if($remove==false)
            {
                //failed to remove image
                $_SESSION['upload'] = "<div class='error'>Failed to remove Image File</div>";
                header('location:'.SITEURL.'admin/manage-books.php');
                //stop the process
                die();
            }
        }

        //3.delete book from database
        $sql = "DELETE FROM tbl_books WHERE id=$id";
        //execute the query
        $res = mysqli_query($conn,$sql);

        //check whether the query is executed or not and set session message
        if($res==true)
        {
            //book deleted
            $_SESSION['delete'] = "<div class='success'>book Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-books.php');
        }
        else
        {
            //failed to delete book
            $_SESSION['upload'] = "<div class='error'>Failed to Delete book</div>";
            header('location:'.SITEURL.'admin/manage-books.php');
        }

        
    }
    else
    {
        //redirect to manage book page
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'admin/manage-books.php');
    }




?>