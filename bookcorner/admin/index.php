<?php include('partials/menu.php'); ?>
   <!--main content section start -->
   <div class="main-content text-center">
      <h1>DASHBOARD</h1><br>
      <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset ($_SESSION['login']);
                }
            ?>
        <div class="wrapper" style="margin-right: 30px;">
          <br>
          <a href="<?php echo SITEURL; ?>admin/manage-user.php" style="text-decoration:none; color: black;">
          <div class="col-4">
            <?php
              $sql = "SELECT * FROM tbl_user";
              //execute query
              $res = mysqli_query($conn,$sql);
              //count rows
              $count = mysqli_num_rows($res);
             ?>
             <h1><?php echo $count; ?></h1>
            <br/>
            Total Users
          </div>
          </a>
          <a href="<?php echo SITEURL; ?>admin/manage-books.php" style="text-decoration:none; color: black;">
    <div class="col-4">
        <?php
        $sql2 = "SELECT SUM(copies_available) AS total_copies FROM tbl_books";
        // Execute query
        $res2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($res2);
        $total_copies = $row2['total_copies'] ?? 0; // If no books, default to 0
        ?>
        <h1><?php echo $total_copies; ?></h1>
        <br/>
        Total Available Books
    </div>
</a>
          <a href="<?php echo SITEURL; ?>admin/manage-order.php" style="text-decoration:none; color: black;">
           <div class="col-4">
            <?php
              $sql3 = "SELECT * FROM tbl_order";
              //execute query
              $res3 = mysqli_query($conn,$sql3);
              //count rows
              $count3 = mysqli_num_rows($res3);
            ?>
            <h1><?php echo $count3; ?></h1>
            <br/>
            Total Orders
           </div>
          </a>
          <a href="<?php echo SITEURL; ?>admin/manage-order.php" style="text-decoration:none; color: black;">
           <div class="col-4">
            <?php
              $sql4 = "SELECT * FROM tbl_order WHERE status IN('Pending','On Delivery')";
              //execute query
              $res4 = mysqli_query($conn,$sql4);
              //count rows
              $count4 = mysqli_num_rows($res4);
            ?>
            <h1><?php echo $count4; ?></h1>
            <br/>
            Pending Orders
           </div>
          </a>
          <div class="col-4">
            <?php
              //sql query to get total revenue generated
              //use aggregate function in sql
              $sql5 = "SELECT SUM(total) AS Total FROM tbl_order WHERE paid='Yes'";
              //execute query
              $res5 = mysqli_query($conn,$sql5);
              
              //get the value
              $row5 = mysqli_fetch_assoc($res5);
              //get the total revenue, if there are no orders wit delivered status,set it to 0
              $total_revenue = isset($row5['Total'])? $row5['Total']:0;
            ?>
            <h1>₹<?php echo $total_revenue?></h1>
            <br/>
            Revenue Generated
          </div>
          <div class="clearfix"></div>
        </div>
    </div>
    <!--main content section ends -->

<?php include('partials/footer.php'); ?>
