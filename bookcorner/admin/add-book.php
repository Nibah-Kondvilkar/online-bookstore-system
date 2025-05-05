<?php include('partials/menu.php'); ?>
<div class="main-content text-center">
    <div class="wrapper">
        <h1>Add Book</h1>
        <br><br>

        <?php
          if(isset($_SESSION['upload']))
          {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
          }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
            <tr>
             <td>Title:</td>
              <td>
              <select name="title" required>
             <option value="" disabled selected>Select Book Title</option>
             <?php
             // Fetch book titles from ordered books
             $sql = "SELECT DISTINCT book_title FROM tbl_supplier_books";
             $res = mysqli_query($conn, $sql);
             if ($res && mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<option value='" . htmlspecialchars($row['book_title'], ENT_QUOTES) . "'>" . htmlspecialchars($row['book_title'], ENT_QUOTES) . "</option>";
                }
             } else {
                echo "<option value='' disabled>No Books Available</option>";
             }
              ?>
             </select>
              </td>
            </tr>
                <tr>
                    <td>Author:</td>
                    <td>
                    <input type="text" name="author" placeholder="Author name" required>
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of book" ></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" required>
                    </td>
                </tr>
                <tr>
                    <td>Genre:</td>
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
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                        <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //we do not have categories
                                    ?>
                                    <option value="0">No Genre Found</option>
                                    <?php
                                }


                                //display on dropdown
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Select Image</td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                </tr>
                <tr>
                    <td>Available Copies:</td>
                    <td>
                        <input type="number" name="copies_available" required>
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" required>Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <input type="submit" name="submit" value="Add Book" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
            //check whether the button is clicked or not
            if(isset($_POST['submit']))
            {
                //add food in database
                //1.get the data from form 
                $title = mysqli_real_escape_string($conn,$_POST['title']);
                $author = mysqli_real_escape_string($conn,$_POST['author']);
                $description = mysqli_real_escape_string($conn,$_POST['description']);
                $price = mysqli_real_escape_string($conn,$_POST['price']);
                $genre = mysqli_real_escape_string($conn,$_POST['genre']);
                $copies_available = mysqli_real_escape_string($conn,$_POST['copies_available']);
                
                //check whether radio button for  active is check or not
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "Yes";//default value
                }
                
                //2.upload the image if selected
                //check whether the select image is clicked or not
                //upload image only if image is selected
                if(isset($_FILES['image']['name']))
                {
                    //get the details of the selected image
                    $image_name = $_FILES['image']['name'];
                    
                    //check whether the image is selected or not and upload image if selected
                    if($image_name!="")
                    {
                        //image is selected
                        //a.remane the image
                        //get the extention of selected image 
                        $ext_array = explode('.',$image_name);
                        $ext = end($ext_array);
                        $image_name = "book-Name-".rand(000,999).'.'.$ext;//new image name 

                        //b.upload the image
                        //get the source path and destination path
                        $src = $_FILES['image']['tmp_name'];//current location 

                        $dst ="../images/book/".$image_name;

                        //upload the food image
                        $upload = move_uploaded_file($src, $dst);

                        //check whether the image is uploaded or not 
                        //if the image is not uploded then stop the process and redirect with error message
                        if($upload==false)
                        {
                           //set message
                           $_SESSION['upload']="<div class='error'>Failed to Upload Image</div>";
                           //redirect to add food page
                           header('location:'.SITEURL.'admin/add-book.php');
                           //stop the process
                           die();
                        }

                    }
                }
                else
                {
                    $image_name = "";//set the default value as blank 
                }

                //3.insert into database
                //no need of quotes for numeric values e.g- price, genre_id
                $sql2 = "INSERT INTO tbl_books SET
                title = '$title',
                author = '$author',
                description = '$description',
                price = $price,
                genre_id = $genre,
                image_name = '$image_name',
                copies_available = $copies_available,
                active = '$active'
                ";

                //execute the query
                $res2 = mysqli_query($conn, $sql2);
                //check whether data inserted or not

                if($res2==true)
                {
                    //data inserted successfully
                    $_SESSION['add']="<div class='success'>Book Added Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-books.php');
                }
                else
                {
                    //failed to insert data
                    $_SESSION['add']="<div class='error'>Failed to Add Book</div>";
                    header('location:'.SITEURL.'admin/manage-books.php');
                }

            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>