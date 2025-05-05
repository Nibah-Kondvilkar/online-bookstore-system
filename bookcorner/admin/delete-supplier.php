<?php
    //include constants.php file here
    include('../config/constants.php');

    //1.get the id of supplierto be deleted 
    $id = $_GET['id'];

    //2.create sql query to delete admin
    $sql = "DELETE FROM tbl_supplier WHERE id=$id";

    //execute the query 
    $res = mysqli_query($conn, $sql);

    //check whether the query executed successfully 
    if($res==true)
    {
        //query executed successfully and supplierdeleted 
        //echo "supplierdeleted";
        //create session variable to display message 
        $_SESSION['delete'] = "<div class='success'> Supplier Deleted Successfully</div>";
        //rediect to manage supplierpage 
        header('location:'.SITEURL.'admin/manage-supplier.php');
    }
    else
    {
        //failed to delete supplier
        //echo "failed to delette supplier";
        $_SESSION['delete'] = "<div class='error'>Failed To Delete Supplier</div> ";
        header('location:'.SITEURL.'admin/manage-supplier.php');

    }

?>