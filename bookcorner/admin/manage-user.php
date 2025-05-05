<?php include('partials/menu.php'); ?>
    <!--main content section start -->
    <div class="main-content text-center">
        <div class="wrapper">
          <section class="search1" >
              <form action="" method="POST">
                <input type="search" name="search" placeholder="search User.."required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
             </form>
          </section>
         <h1>Manage User</h1>
          <br/>
          <?php 
            if(isset($_SESSION['update']))
            {
              echo $_SESSION['update'];
              unset($_SESSION['update']);
            }
          ?>
           <br/>
          <table class="tbl-full ">
            <tr>
              <th>S.N</th>
              <th>Full Name</th>
              <th>Username</th>
              <th>Contact</th>
              <th>Email</th>
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
              $sql = "SELECT * FROM tbl_user WHERE full_name LIKE '%$search%' OR username LIKE '%$search%'";
            }else{
            //default query to get all user
              $sql=  "SELECT * FROM tbl_user " ;
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
                    $username=$rows['username'];
                    $contact = $rows['contact'];
                    $email=$rows['email'];

                    //display the values in our table
                    ?>
                       <tr>
                          <td><?php echo $sn++;?></td>
                         <td><?php echo $full_name;?></td>
                         <td><?php echo $username;?></td>
                         <td><?php echo $contact;?></td>
                         <td><?php echo $email;?></td>
                         <td>
                         <a href="<?php echo SITEURL;?>admin/update-user.php?id=<?php echo $id;?>" class="btn-secondary">Update Customer</a>
                         </td>
                       </tr>
                       
                    <?php
                  }
                }else
                {
                  //we do not have data in database
                  ?>
                  <tr>
                    <td colspan="5"><div class="error">No User Found</div></td>
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