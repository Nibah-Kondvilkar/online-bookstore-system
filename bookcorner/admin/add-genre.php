<?php include('partials/menu.php'); ?>

    <div class="main-content text-center">
        <div class="wrapper">
            <h1>Add Genre</h1>
            <br><br>

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
            ?>
            <br>
             <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td>
                            <input type="text" name="title" placeholder="Genre title" required>
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
                        <input type="submit" name="submit" value="Add Genre" class="btn-secondary">
                    </td>
                    </tr>

                </table>
             </form>
           
             <?php
              //check whether the submit button is clicked or not 
              if(isset($_POST['submit']))
              {
                //echo "clicked";

                //1.get the value from form
                $title = $_POST['title'];

                //for radio input we need to check whether the button is sleceted or not
                if(isset($_POST['active']))
                {
                    //get the value from form 
                    $active = $_POST['active'];
                }
                else
                {
                    //set default value
                    $active = "Yes";
                }
                
                //2. create sql query to insert category into database
                $sql = "INSERT INTO tbl_genre SET
                    title='$title',
                    active= '$active'
                ";

                //3.execute the query and save in database
                $res = mysqli_query($conn, $sql);

                //4.check whether the query executed or not and data added or not
                if($res==true)
                {
                    //query executed and category added
                    $_SESSION['add']="<div class='success'>Genre Added Successfully</div>";
                    //redirect to manage-category page
                    header('location:'.SITEURL.'admin/manage-genre.php');
                }
                else
                {
                    //failed to add category
                    $_SESSION['add']="<div class='error'>Failed To Add Genre</div>";
                    //redirect to manage-category page
                    header('location:'.SITEURL.'admin/add-genre.php');
                }

              }
             ?>

        </div>
    </div>

<?php include('partials/footer.php'); ?>
