<?php include('partials/menu.php'); ?>

<div class="main-content text-center">
        <div class="wrapper">
          <h1>Manage Genre</h1>
          <br/>
          <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                if(isset($_SESSION['no-genre-found']))
                {
                    echo $_SESSION['no-genre-found'];
                    unset($_SESSION['no-genre-found']);
                }
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            ?>
            <br>
          <!-- button to add category-->
           <a href="<?php echo SITEURL;?>admin/add-genre.php" class="btn-primary">Add Genre</a>
          <br/><br/>
          <table class="tbl-full ">
            <tr>
              <th>S.N</th>
              <th>Title</th>
              <th>Active</th>
              <th>Actions</th>
            </tr>

            <?php
                
              //query to get all category from database
              $sql = "SELECT * FROM tbl_genre";

              //execute the query
              $res = mysqli_query($conn, $sql);

              //count rows
              $count = mysqli_num_rows($res);

              //create serial number variable ans assign value as 1
              $sn=1;

              //check whether we have data in database or not
              if($count>0)
              {
                //we have data in database
                //get data and display
                while($row = mysqli_fetch_assoc($res))
                {
                  $id = $row['id'];
                  $title = $row['title'];
                  $active = $row['active'];

                  ?>
                  
                  <tr>
                   <td><?php echo $sn++;?></td>
                   <td><?php echo $title ;?></td>
                   <td><?php echo $active ;?></td>
                   <td>
                    <a href="<?php echo SITEURL;?>admin/update-genre.php?id=<?php echo $id;?>" class="btn-secondary">Update Genre</a>
                    <a href="<?php echo SITEURL;?>admin/delete-genre.php?id=<?php echo $id;?>" class="btn-danger">Delete Genre</a>
                   </td>
                   </tr>
                  <?php

                }
              }
              else
              {
                //we do not have data
                //we will display the message inside table, break the php
                ?>
                <tr>
                  <td colspan="6"><div class="error">No Genre Added</div></td>
                </tr>
                <?php
              }

            ?>

            
            
          </table>
          <br/><br/>
          
        </div>
    </div>

<?php include('partials/footer.php'); ?>