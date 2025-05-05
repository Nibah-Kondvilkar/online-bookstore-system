<?php 
include('partials-front/menu.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$totalAmount = 0;
$modalMessage = '';
$showModal = false;

// Handle removing items from the cart
if (isset($_POST['remove'])) {
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    //get current quantity
    $quantity_sql = "SELECT quantity FROM tbl_cart WHERE id = '$cart_id' AND user_id = '$user_id' ";
    $quantity_res = mysqli_query($conn, $quantity_sql);
    $quantity_row = mysqli_fetch_assoc($quantity_res);
    $quantity = $quantity_row['quantity'];

    if($quantity > 1){
        //remove item 1 by 1
        $update_sql = "UPDATE tbl_cart SET quantity = quantity - 1 WHERE id = '$cart_id' AND user_id = '$user_id' ";
        mysqli_query($conn, $update_sql);
        $modalMessage = "Item deleted";
        $showModal = true;
    }
    else{
        //remove item from cart
        $sql = "DELETE FROM tbl_cart WHERE id = '$cart_id' AND user_id = '$user_id'";
        mysqli_query($conn, $sql);
        $modalMessage = "Item removed from cart";
        $showModal = true;
    }
}
// Handle removing all items from the cart
if (isset($_POST['remove_all'])) {
    $sql = "DELETE FROM tbl_cart WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $sql)) {
        $modalMessage = "All items removed from cart";
        $showModal = true;
    }
}
if(isset($_POST['checkout'])){
    $_SESSION['can_checkout'] = true;
    header("Location: checkout.php");
    exit();
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="../css/user.css">
</head>
<body>
<section  style="background-color: #dda876;">
       <div class="container">
       <h2 class="text-center">Your Cart</h2>
    
    <table class="cart">
        <tr>
            <th>Book Item</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Remove Item</th>
        </tr>
        
        <?php 
           // Get items in the cart
           $sql = "SELECT c.*, b.title, b.price FROM tbl_cart c JOIN 
           tbl_books b ON c.book_id = b.id WHERE c.user_id = '$user_id' ORDER BY c.id DESC";
           $res = mysqli_query($conn, $sql);

           //check if cart is empty
           $cartempty = (mysqli_num_rows($res) === 0);
        
          if(mysqli_num_rows($res)>0){
            while ($row = mysqli_fetch_assoc($res)) { 
                $book_id = $row['book_id'];
                $title = $row['title'];
                $price = $row['price'];
                $quantity = $row['quantity'];

                $itemTotal = $price * $quantity;
                $totalAmount += $itemTotal;

                
                ?>
            <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td>₹<?php echo htmlspecialchars($row['price']); ?></td>
            <td class="cart-qty"><?php echo htmlspecialchars($row['quantity']); ?></td>
            <td class="cart-tol">₹<?php echo htmlspecialchars($itemTotal); ?></td>
            <td>
                <form action="cart.php" method="POST">
                    <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($row['id']); ?>" >
                    <button type="submit" name="remove" class="cartbtn">Remove</button>
                </form>
            </td>
        </tr>
        <?php } 
        }else{
             echo "<tr><td colspan='5' class='text-center'><strong>Your cart is empty</strong></td></tr>";
        }?>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total Amount:</strong></td>
                <td colspan="2">₹<?php echo $totalAmount;?></td>
            </tr>
        </tfoot>
    </table>
    
    <!--if cart is not empty go to checkout page-->
    <?php if(!$cartempty){?>
        <div class="cart-buttons">
     <form action="" method="POST">
        <button type="submit" name="checkout" class="cartbtn-btn">Checkout</button>
     </form>
     <form action="" method="POST">
        <button type="submit" name="remove_all" class="cartbtn-btn remove-all">Remove All Items</button>
     </form>
     </div>
      <?php } ?>

        

        <!-- to show the message -->
        <div class="modal <?php echo  $showModal ? 'show' : '';?>">
            <div class="modal-content">
            <p><?php echo htmlspecialchars($modalMessage);?></p>
                <form action="" method="POST">
                    <button type="submit" name="okbutton" value="submit" >OK</button>
                </form>
            </div>
        </div>
         
</body>
<br><br>
</html>
<br><br><br><br>
</div>
</section>
<?php include('partials-front/footer.php');?>