<?php include('partials/menu.php'); ?>

<div class="main-content text-center">
    <div class="wrapper">
        <h1>Update Genre</h1>
        <br>
       
        <?php

          if(isset($_GET['id']))
          {
            //get the id and details
            $id = $_GET['id'];
            //create sql query to get details
            $sql = "SELECT * FROM tbl_genre WHERE id=$id";
            //execute the query
            $res = mysqli_query($conn, $sql);

            //count the rows to check whether the id is valid or not
            $count = mysqli_num_rows($res);
            if($count==1)
            {
                //get the data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $active = $row['active'];
            }
            else
            {
                //redirect to manage Genre page with session message
                $_SESSION['no-genre-found'] = "<div class='error'>Genre Not Found</div>";
                header('location:'.SITEURL.'admin/manage-genre.php');
            }
          }
          else
          {
            //redirect to manage Genre page
            header('location:'.SITEURL.'admin/manage-genre.php');
          }
        ?>



      <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
               <td>Title:</td>
               <td>
                <input type="text" name="title" value="<?php echo $title;?>">
               </td>
             </tr>
            <tr>
                <td>Active:</td>
                <td>
                    <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes
                    <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No">No
                </td>
            </tr>
            <tr>
                <td >
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="submit" name="submit" value="Update Genre" class="btn-secondary">
                </td>
            </tr>

        </table>
      </form>
      <?php
        if(isset($_POST['submit']))
        {
            //echo "clicked";
            //1.get all the values from our form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $active = $_POST['active'];

            //2.update the database
            $sql2 = "UPDATE tbl_genre SET
              title = '$title',
              active = '$active'
              WHERE id = $id
            ";

            //execute the query
            $res2 = mysqli_query($conn, $sql2);

            //3.redirect to manage Genre with message
            //check whether query executed or not
            if($res2==true)
            {
                //Genre update
                $_SESSION['update'] = "<div class='success'>Genre Updated Successfully</div>";
                header('location:'.SITEURL.'admin/manage-genre.php');
            }
            else
            {
                //failed to update Genre
                $_SESSION['update'] = "<div class='error'>Failed To Update Genre </div>";
                header('location:'.SITEURL.'admin/manage-genre.php');
            }
        }
      ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>