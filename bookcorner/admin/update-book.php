<?php include('partials/menu.php'); 
ob_start();
?>

<?php
    //check whether id is set or not
    if(isset($_GET['id']))
    {
      //get the id and details
      $id = $_GET['id'];
      //create sql query to get details
      $sql2 = "SELECT * FROM tbl_books WHERE id=$id";
      //execute the query
      $res2 = mysqli_query($conn, $sql2);

      //get the valuse based on query executed
      $row2 = mysqli_fetch_assoc($res2);
      //get the individual values of selected book
      $title = $row2['title'];
      $author = $row2['author'];
      $description = $row2['description'];
      $price = $row2['price'];
      $current_genre_id = $row2['genre_id'];
      $current_image = $row2['image_name'];
      $copies_available = $row2['copies_available'];
      $active = $row2['active'];
    
    }
    else
    {
      //redirect to manage genre page
      header('location:'.SITEURL.'admin/manage-genre.php');
    }
?>

<div class="main-content text-center">
    <div class="wrapper">
        <h1>Update Book</h1>
        <br>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
         <tr>
            <td>Title:</td>
            <td>
            <input type="text" name="title" value="<?php echo $title;?>">
            </td>
         </tr>
               <tr>
                   <td>Author:</td>
                    <td>
                    <input type="text" name="author" value="<?php echo $author;?>">
                    </td>
                </tr>
                <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description;?></textarea>
                </td>
            </tr>
            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price;?>">
                </td>
            </tr>
            <tr>
                <td>genre: </td>
                <td>
                    <select name="genre">
                    <?php
                        //to display genre from database
                        //1.create sql query to get all active categories from database
                        $sql = "SELECT * FROM tbl_genre WHERE active='Yes'";
                                
                        //execute the query
                        $res = mysqli_query($conn,$sql);

                        //count rows to check whether we have categories or not
                        $count = mysqli_num_rows($res);

                        if($count>0)
                        {
                            //we have categories
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //get the detail of categories
                                $genre_title = $row['title'];
                                $genre_id = $row['id'];
                                ?>
                                <option <?php if($current_genre_id==$genre_id){echo "selected";}?> 
                                value="<?php echo $genre_id;?>"><?php echo $genre_title;?></option>
                                <?php
                            }
                        }
                        else
                        {
                            //we do not have genre
                            ?>
                            <option value="0">No genre Found</option>
                            <?php
                        }

                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Current Image: </td>
                <td>
                    <?php
                       if($current_image !="")
                       {
                        //display image
                        ?>
                        <img src="<?php echo SITEURL; ?>images/book/<?php echo $current_image; ?>" width="80px">
                        <?php
                       }
                       else
                       {
                        //display message
                        echo "<div class='error'>Image Not Added</div>";
                       }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Select Image</td>
                <td>
                    <input type="file" name="image" >
                </td>
            </tr>
            <tr>
                <td>Available Copies: </td>
                <td>
                    <input type="number" name="copies_available" value="<?php echo $copies_available;?>">
                </td>
            </tr>
            <tr>
                <td>Active: </td>
                <td>
                    <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes
                    <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No">No
                </td>
            </tr>
            <tr>
                <td colspan="2">
                
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update book" class="btn-secondary">
                </td>
            </tr>
        </table>

        </form>
        <?php
        if(isset($_POST['submit']))
        {
            //echo "clicked";
            //1.get all the values from our form
            $id = mysqli_real_escape_string($conn,$_POST['id']);
            $title = mysqli_real_escape_string($conn,$_POST['title']);
            $author = mysqli_real_escape_string($conn,$_POST['author']);
            $description = mysqli_real_escape_string($conn,$_POST['description']);
            $price = mysqli_real_escape_string($conn,$_POST['price']);
            $genre = mysqli_real_escape_string($conn,$_POST['genre']);
            $current_image = mysqli_real_escape_string($conn,$_POST['current_image']);
            $copies_available = mysqli_real_escape_string($conn,$_POST['copies_available']);
            $active = $_POST['active'];

            //2.updating new image if selected
            //check whether the image is selected or not
            if(isset($_FILES['image']['name']))
            {
                //get the image details
                $image_name = $_FILES['image']['name'];
                //check whether image is available or not
                if($image_name !="")
                {
                    //image available
                    //A.uploading new image
                    //get the extension of our image
                    $img_parts = explode('.',$image_name);
                    $ext = end($img_parts);
                    //rename the image
                    $image_name = "book-Name-".rand(000,999).'.'.$ext;
                    //e.g we have rename book.jpg into book-Name-30(any random num).jpg


                    $src_path = $_FILES['image']['tmp_name'];

                    $dest_path="../images/book/".$image_name;

                    //upload the image
                    $upload = move_uploaded_file($src_path, $dest_path);

                    //check whether the image is uploaded or not 
                    //if the image is not uploded then stop the process and redirect with error message
                    if($upload==false)
                    {
                        //set message
                        $_SESSION['upload']="<div class='error'>Failed to Upload Image</div>";
                        //redirect to manage book page
                        header('location:'.SITEURL.'admin/manage-books.php');
                        //stop the process
                        die();
                    }
                    //B.remove the current image if available
                    if($current_image!="")
                    {
                     $remove_path = "../images/book/".$current_image;
                     $remove= unlink($remove_path);

                     //check whether the image is remove or not 
                     //if failed to remove  then display the message and stop the process
                     if($remove==false)
                     {
                        //failed to remove the image
                        $_SESSION['remove-failed']="<div class='error'>Failed to remove current Image</div>";
                        header('location:'.SITEURL.'admin/manage-books.php');
                        die();
                     }
                    }
                }
                else
                {
                    $image_name = $current_image;
                }
            }
            else
            {
                $image_name = $current_image;
            }


            //3.update the database
            $sql3 = "UPDATE tbl_books SET
              title = '$title',
              author = '$author',
              description = '$description',
              price = $price,
              genre_id = '$genre',
              image_name = '$image_name',
              copies_available = '$copies_available',
              active = '$active'
              WHERE id = $id
            ";

            //execute the query
            $res3 = mysqli_query($conn, $sql3);

            //4.redirect to manage book with message
            //check whether query executed or not
            if($res3==true)
            {
                //book update
                $_SESSION['update'] = "<div class='success'>Book Updated Successfully</div>";
                header('location:'.SITEURL.'admin/manage-books.php');
            }
            else
            {
                //failed to update book
                $_SESSION['update'] = "<div class='error'>Failed To Update Book </div>";
                header('location:'.SITEURL.'admin/manage-books.php');
            }
        }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>