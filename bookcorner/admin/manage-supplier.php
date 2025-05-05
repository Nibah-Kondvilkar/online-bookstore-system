<?php include('partials/menu.php'); 
ob_start();
?>
    <!--main content section start -->
    <div class="main-content text-center">
        <div class="wrapper">
          <section class="search1" >
              <form action="" method="POST">
                <input type="search" name="search" placeholder="search supplier.."required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
             </form>
          </section>
         <h1>Manage Supplier</h1>
          <br/>
          <?php 
            if(isset($_SESSION['add']))
            {
              echo $_SESSION['add'];//displaying session message
              unset($_SESSION['add']); //removing session message
            }
            if(isset($_SESSION['delete']))
            {
              echo $_SESSION['delete'];
              unset($_SESSION['delete']);
            }
            if(isset($_SESSION['update']))
            {
              echo $_SESSION['update'];
              unset($_SESSION['update']);
            }
          ?>
          <br><br>
          <!-- button to add staff-->
           <a href="add-supplier.php" class="btn-primary">Add Supllier</a>
           <br/><br/>
          <table class="tbl-full ">
            <tr>
              <th>S.N</th>
              <th>Full Name</th>
              <th>Contact</th>
              <th>Email</th>
              <th>Address</th>
              <th>Actions</th>
            </tr>

            <?php
            //initialize the serial number
            $sn=1;//create a variable and assign the value

            //check if the search form has been submitted
            if(isset($_POST['submit'])){
              //get the search term
              $search = mysqli_real_escape_string($conn,$_POST['search']);

              //modify the query to search for user based on search term
              $sql = "SELECT * FROM tbl_supplier WHERE full_name LIKE '%$search%' ";
            }else{
            //default query to get all user
              $sql=  "SELECT * FROM tbl_supplier " ;
            } 
              //execute the query
              $res= mysqli_query($conn,$sql);
              //check whether the query is executed or not
              if($res==TRUE)
              {
                //count rows to check whether we have data in database or not 
                $count = mysqli_num_rows($res);//function to get all the rows in database 

                //check the num of rows
                if($count>0){
                  //we have data in database
                  while($rows=mysqli_fetch_assoc($res))
                  {
                    //using while loop to get all the data from database
                    //and while loop will run as long as we have data in database

                    //get individual data
                    $id=$rows['id'];
                    $full_name=$rows['full_name'];
                    $contact = $rows['contact'];
                    $email=$rows['email'];
                    $address=$rows['address'];

                    //display the values in our table
                    ?>
                       <tr>
                          <td><?php echo $sn++;?></td>
                         <td><?php echo $full_name;?></td>
                         <td><?php echo $contact;?></td>
                         <td><?php echo $email;?></td>
                         <td><?php echo $address;?></td>
                         <td>
                         <a href="<?php echo SITEURL;?>admin/update-supplier.php?id=<?php echo $id;?>" class="btn-secondary">Update Supplier</a>
                         <a href="<?php echo SITEURL; ?>admin/delete-supplier.php?id=<?php echo $id; ?>" class="btn-danger">Delete Supplier</a>
                         <a href="<?php echo SITEURL; ?>admin/book-info.php?id=<?php echo $id; ?>" class="btn-primary">Book Info</a>
                         </td>
                       </tr>
                       
                    <?php
                  }
                }else
                {
                  //we do not have data in database
                  ?>
                  <tr>
                    <td colspan="5"><div class="error">No Supplier Found</div></td>
                  </tr>
                  <?php
                }
              }     
            ?>
          </table>
        </div>
    </div>
    <!--main content section ends -->

<?php include('partials/footer.php'); ?>