<?php include('partials/menu.php'); 
ob_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
?>
<?php
// Auto-update Paid to 'Yes' for Online Payments in Database
$update_paid_sql = "UPDATE tbl_order SET paid = 'Yes' WHERE payment_mode = 'Online' AND paid != 'Yes'";
mysqli_query($conn, $update_paid_sql);
?>
<div class="main-content text-center">
    <div class="wrapper">
        <h1>Manage Order</h1>
        <br/>

        <?php
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br>
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Username</th>
                <th>Orders</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Payment Mode</th>
                <th>Paid</th>
                <th>Order-Date</th>
                <th>Status</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <?php
            // Pagination
            $limit = 5;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            // Total number of orders
            $total_sql = "SELECT COUNT(*) AS total FROM tbl_order";
            $total_res = mysqli_query($conn, $total_sql);
            $total_row = mysqli_fetch_assoc($total_res);
            $total_orders = $total_row['total'];
            $total_pages = ceil($total_orders / $limit);

            // Fetch orders
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC LIMIT $limit OFFSET $offset";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            $sn = $offset + 1;

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $orders = $row['orders'];
                    $price = $row['price'];
                    $quantity = $row['quantity'];
                    $total = $row['total'];
                    $payment_mode = $row['payment_mode'];
                    $paid = $row['paid'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $user_name = $row['user_name'];
                    $user_contact = $row['user_contact'];
                    $user_email = $row['user_email'];
                    $user_address = $row['user_address'];
                    ?>

                    <tr>
                        <form method="POST" action="">
                        <td><?php echo $sn++; ?>.</td>
                        <td><?php echo $user_name; ?></td>
                        <td><?php echo $orders; ?></td>
                        <td>₹<?php echo $price; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td>₹<?php echo $total; ?></td>
                        <td><?php echo $payment_mode; ?></td>
                        <td>
                         <?php if ($payment_mode == 'Online') { ?>
                          <input type="hidden" name="paid" value="Yes">
                          <span style="color: green; font-weight: bold;">Yes</span>
                          <?php } elseif ($payment_mode == 'COD' && $paid == 'Yes') { ?>
                           <input type="hidden" name="paid" value="Yes">
                           <span style="color: green; font-weight: bold;">Yes</span>
                          <?php } elseif ($payment_mode == 'COD' && $status == 'Cancelled') { ?>
                            <input type="hidden" name="paid" value="<?php echo $paid; ?>">
                            <span style="color: red; font-weight: bold;"><?php echo $paid; ?> </span>
                          <?php } else { ?>
                              <select name="paid">
                                <option value="No" <?php if ($paid == 'No') echo 'selected'; ?>>No</option>
                                <option value="Yes" <?php if ($paid == 'Yes') echo 'selected'; ?>>Yes</option>
                              </select>
                           <?php } ?>
                          
                        </td>
                        <td><?php echo $order_date; ?></td>
                        <td>
                            <select name="status"  <?php if ($status == 'Delivered' || $status == 'Cancelled') echo 'disabled';?>>
                                <option value="Pending" <?php if ($status == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="On Delivery" <?php if ($status == 'On Delivery') echo 'selected'; ?>>On Delivery</option>
                                <option value="Delivered" <?php if ($status == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                <?php if(!($payment_mode == 'Online' && $paid == 'Yes')) {?>
                                <option value="Cancelled" <?php if ($status == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                <?php }?>
                            </select>
                        </td>
                        
                        <td><?php echo $user_contact; ?></td>
                        <td><?php echo $user_email; ?></td>
                        <td><?php echo $user_address; ?></td>
                        <td>
                            <!--<a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>-->
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <button class="btn-secondary" name="update" type="submit"> update</button>
                        </td>
                        </form>
                    </tr>

                    <?php
                }
            } else {
                echo "<tr><td colspan='13' class='error'>Order Not Available</td></tr>";
            }
            ?>
        </table>
        <?php
        if (isset($_POST['update'])) {
            $status = $_POST['status'];
            $paid = $_POST['paid'];
            $id = $_POST['id'];
        
            // Get the current status and paid value from the database before updating
            $sql_check = "SELECT status, paid, user_email, user_name FROM tbl_order WHERE id = '$id'";
            $res_check = mysqli_query($conn, $sql_check);
            $row_check = mysqli_fetch_assoc($res_check);
            $user_email = $row_check['user_email'];
            $user_name = $row_check['user_name'];
            $old_status = $row_check['status'];  // Previous status before update
            $old_paid = $row_check['paid'];      // Previous paid value before update
        
            // Update the order in the database
            $sql2 = "UPDATE tbl_order SET status = '$status', paid = '$paid' WHERE id = '$id'";
            $res2 = mysqli_query($conn, $sql2);
        
            if ($res2 == true) {
                // Check if only status is updated (not paid)
                if ($old_status != $status) {
                    sendStatusUpdateEmail($user_email, $status, $user_name);
                }
        
                // Success message
                $_SESSION['update'] = "<div class='success'>Order updated Successfully</div>";
                header('location:' . SITEURL . 'admin/manage-order.php');
            } else {
                // Failure message
                $_SESSION['update'] = "<div class='error'>Failed to update order</div>";
                header('location:' . SITEURL . 'admin/manage-order.php');
            }
        }

    function sendStatusUpdateEmail($user_email, $status, $user_name) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username   = 'kondvilkarnibah@gmail.com';  // my Gmail
            $mail->Password   = 'ubtw gyvu eneq pwhf';    // App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('kondvilkarnibah@gmail.com', 'Book Corner');
            $mail->addAddress($user_email);

            $mail->isHTML(true);

            // Determine the email content based on the status
            switch ($status) {
                case 'On Delivery':
                    $mail->Subject = 'Your Order is On the Way!';
                    $mail->Body = "Dear $user_name,<br>Your order is on the way! You will receive it soon.<br>Best regards,<br>The Book Corner Team";
                    break;
                case 'Delivered':
                    $mail->Subject = 'Your Order has been Delivered!';
                    $mail->Body = "Dear $user_name,<br>Your order has been successfully delivered!<br>Best regards,<br>The Book Corner Team";
                    break;
                case 'Cancelled':
                    $mail->Subject = 'Order Cancelled';
                    $mail->Body = "Dear $user_name,<br>Your order has been cancelled.<br>If you have any questions, feel free to contact us.<br>Best regards,<br>The Book Corner Team";
                    break;
                default:
                    $mail->Subject = 'Order Update';
                    $mail->Body = "Dear $user_name,<br>Your order status has been updated to <b>$status</b>.<br>Best regards,<br>The Book Corner Team";
            }

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
?>
        <!--pagination-->
        <?php if ($total_pages > 1) : ?>
    <div class="pagination">
    <!-- Previous arrow -->
    <a href="?page=<?php echo max(1, $page - 1); ?>" 
       class="prev <?php if ($page == 1) echo 'disabled'; ?>" 
       <?php if ($page == 1) echo 'style="pointer-events: none; opacity: 0.5;"'; ?>>
        &#10094;
    </a>

    <!-- First page link -->
    <a href="?page=1" class="<?php if ($page == 1) echo 'active'; ?>">1</a>

    <!-- Show ellipsis if needed before current range -->
    <?php if ($page > 3 && $total_pages > 3) : ?>
        <span>...</span>
    <?php endif; ?>

    <!-- Dynamic page links based on current page -->
    <?php
    for ($i = max(2, $page - 1); $i <= min($page + 1, $total_pages - 1); $i++) {
        echo "<a href='?page=$i' class='" . ($i == $page ? 'active' : '') . "'>$i</a>";
    }
    ?>

    <!-- Show ellipsis if needed after current range -->
    <?php if ($page < $total_pages - 2 && $total_pages > 3) : ?>
        <span>...</span>
    <?php endif; ?>

    <!-- Last page link -->
    <?php if ($total_pages > 1) : ?>
        <a href="?page=<?php echo $total_pages; ?>" 
           class="<?php if ($page == $total_pages) echo 'active'; ?>">
            <?php echo $total_pages; ?>
        </a>
    <?php endif; ?>

    <!-- Next arrow -->
    <a href="?page=<?php echo min($total_pages, $page + 1); ?>" 
       class="next <?php if ($page == $total_pages) echo 'disabled'; ?>" 
       <?php if ($page == $total_pages) echo 'style="pointer-events: none; opacity: 0.5;"'; ?>>
        &#10095;
    </a>
</div>
<?php endif; ?>

</div>
</div>
<?php include('partials/footer.php'); ?>