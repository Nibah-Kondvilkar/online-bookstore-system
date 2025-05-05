<?php include('partials-front/menu.php');?>
<?php

$user_id = $_SESSION['user_id'];

//query to get user order
$sql = "SELECT * FROM tbl_order WHERE user_id = $user_id ORDER BY order_date DESC";
$res = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/user.css">
</head>
<body>
      <section  style="background-color: #dda876;">
       <div class="container">
       <h2 class="text-center">Your Previous Orders</h2>
    

    <table class="cart">
        <tr>
            <th>Book Item</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Order Date</th>
            <th>Status</th>
        </tr>
        
        <?php
        if(mysqli_num_rows($res)>0){
            while ($row = mysqli_fetch_assoc($res)) { 
                $order_id = $row['id'];
                $orders = $row['orders'];
                $price = $row['price'];
                $quantity = $row['quantity'];
                $total = $row['total'];
                $order_date = $row['order_date'];
                $status = $row['status'];
              
                ?>
                <tr>
                 <td><?php echo htmlspecialchars($row['orders']); ?></td>
                 <td>₹<?php echo htmlspecialchars($row['price']); ?></td>
                 <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                 <td>₹<?php echo htmlspecialchars($row['total']); ?></td>
                 <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                 <td>
                          <?php 
                          //pending, on delivery, delivered and cancelled
                          if($status=="Pending") 
                          {
                            echo "<label style='color:rgb(87, 47, 9);'>$status</label>";
                          }
                          elseif($status=="On Delivery")
                          {
                            echo "<label style='color:rgb(131, 63, 0);'>$status</label>";
                          }
                          elseif($status=="Delivered")
                          {
                            echo "<label style='color:green;'>$status</label>";
                          }
                          elseif($status=="Cancelled")
                          {
                            echo "<label style='color:red;'>$status</label>";
                          }

                          ?>
                        </td>
                 <!--<td><?php echo htmlspecialchars($row['status']); ?></td>-->
                </tr>

            <?php }
        } else{ 
            echo "<tr><td colspan='6' class='text-center'><strong>You don't have any previous order </strong></td></tr>";
        }
         ?>
    </table>
</body>
<br><br>
</html>
<br><br><br><br><br><br>
</div>
      </section>
<?php include('partials-front/footer.php');?>