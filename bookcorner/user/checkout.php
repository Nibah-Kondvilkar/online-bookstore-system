<?php
include('../config/constants.php');
//include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

//check if session flag is set
if(!isset($_SESSION['can_checkout']) || $_SESSION['can_checkout'] !==true){
    header("Location: cart.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// Get the total amount from cart
$sql = "SELECT SUM(total_price) AS cart_total FROM tbl_cart WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$cart_total = $row['cart_total'];


//retrieve user details from the database
$sql_user = "SELECT full_name, contact, email, address FROM tbl_user WHERE id='$user_id'";
$res_user = mysqli_query($conn,$sql_user);
if($res_user && mysqli_num_rows($res_user)>0){
    $row_user = mysqli_fetch_assoc($res_user);
    $user_name = $row_user['full_name'];
    $user_contact = $row_user['contact'];
    $user_email = $row_user['email'];
    $user_address = $row_user['address'];
}
else{
    $user_name = '';
    $user_contact = '';
    $user_email = '';
    $user_address = '';
}
// Handle form submission for order confirmation
if (isset($_POST['confirm_order'])) {
    //determine the name to be used for the order
    if($_POST['order_for'] === 'myself'){
        $user_name = $user_name;//use the login user name
    }else{
        $user_name = mysqli_real_escape_string($conn, $_POST['full_name']);//use the entered name
    }
    $user_contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $user_email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment_mode = mysqli_real_escape_string($conn, $_POST['payment_mode']);
    $order_date = date("Y-m-d H:i:s");
    $status = "Ordered";

    //retrive cart item
    $sql2 = "SELECT book_id,title, quantity, price FROM tbl_cart WHERE user_id='$user_id'";
    $cart_res = mysqli_query($conn, $sql2);
    
    $title=[];
    $price = [];
    $quantity = [];
    $total= 0;

    while($row = mysqli_fetch_assoc($cart_res)){
        //collect all order name
       $title[] = mysqli_real_escape_string($conn, $row['title']);
       $price[]= $row['price'];
       $quantity[] = $row['quantity'];
       $total += $row['quantity'] * $row['price'] ;
    }
    //convert it into string
    $title_str = implode(',',$title);
    $price_str = implode(',',$price);
    $quantity_str = implode(',',$quantity);
    
    $paid = ($payment_mode === 'Online') ? 'Yes' : 'No';
    $status = 'Pending';
    // Insert order into tbl_order
    $sql = "INSERT INTO tbl_order (user_id,orders, price, quantity, total, payment_mode, paid, order_date, status, user_name, user_contact, user_email, user_address) VALUES ('$user_id','$title_str','$price_str', '$quantity_str','$total','$payment_mode', '$paid','$order_date', '$status', '$user_name', '$user_contact', '$user_email', '$user_address')";
    $res = mysqli_query($conn, $sql);  
    
    if ($res) {
           // Update stock in tbl_books
           foreach ($cart_res as $row) {
          $book_id = $row['book_id'];
          $quantity_ordered = $row['quantity'];

         // Reduce the stock
          $update_stock_sql = "UPDATE tbl_books SET copies_available = copies_available - $quantity_ordered WHERE id = $book_id";
          mysqli_query($conn, $update_stock_sql);
         }
            //send the email to user
            $mail = new PHPMailer(true);

            try {
            // Server settings
            $mail->isSMTP();                                          
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                 
            $mail->Username   = 'kondvilkarnibah@gmail.com';  // my Gmail
            $mail->Password   = 'ubtw gyvu eneq pwhf';    // App Password
            $mail->SMTPSecure = 'tls';                                
            $mail->Port       = 587;                                  

            // Recipients
            $mail->setFrom('kondvilkarnibah@gmail.com', 'Book Corner');
            $mail->addAddress($user_email);        

            // Content
            $mail->isHTML(true);                                      
            $mail->Subject = 'Order Confirmation';
            $mail->Body = "Dear $user_name,<br>Thankyou for your order.<br><br>Order Details:<br>Food: $title_str<br>Quantity: $quantity_str <br>Total Price: ₹$total <br><br>Best regards,<br>The Book Corner Team";

            $mail->send();
             echo 'message has been send';
           } catch (Exception $e) {
              echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            //order status
            $_SESSION['order_status'] = "Your order has been placed!";
            unset($_SESSION['can_checkout']);
             
            // Clear the cart
            $sql = "DELETE FROM tbl_cart WHERE user_id = '$user_id'";
            mysqli_query($conn, $sql);


            header("Location: order-confirm.php");
            exit();
            
    } else {
        $_SESSION['order_status'] = "order failed";
        exit();
    }
} 

?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/user.css">
    <style>
        #fullNameField{
            display: none;
        }
    </style>
</head>
<body>
    <section class="order-section">
    <div class="container">
    <h2 class="text-center text-beige">Fill this form to confirm your order.</h2>

    <form id="orderForm" action="checkout.php" method="POST" class="order">
        <fieldset style="color:white; border: 1px solid white; background-color:rgb(167, 114, 65);">
            <legend>Delivery Details</legend>
            <div class="order-label">You are ordering for:</div>
            <div>
                <label>
                    <input type="radio" name="order_for" value="myself" onclick="toggleFields(true)" required >Myself (<?php echo htmlspecialchars($user_name); ?>)
                </label>
            </div>
            <div>
                <label>
                    <input type="radio" name="order_for" value="someone_else" required onclick="toggleFields(false)">Someone Else
                </label>
            </div>
             <div id="fullNameField">
             <div class="order-label">Full Name:**</div>
              <input type="text" name="full_name" id="fullName" placeholder="E.g. Nibah Kondvilkar" class="input-responsive" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
             </div>
            <div class="order-label">Phone Number:</div>
            <input type="text" name="contact" pattern="[789][0-9]{9}" maxlength="10" placeholder="E.g. 9015xxxxxx" class="input-responsive" required oninput="this.value = this.value.replace(/\D/g, ''); if (this.value.length === 1 && !/[789]/.test(this.value)) {
                this.value = '';}this.value = this.value.slice(0, 10);">

            <div class="order-label">Email:</div>
            <input type="email" name="email" placeholder="E.g. nibah@gmail.com" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" class="input-responsive" required>

            <div class="order-label">Address:</div>
            <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>
 
            <input type="hidden" name="total_amount" id="total_amount" value="100">
            <input type="hidden" name="payment_mode" id="payment_mode">
            <div class="order-label">Payment Mode:</div>
            <div>
               <label>
               <button type="submit" name="confirm_order" class="btn-primary" onclick="setPaymentMode('COD')">Cash on Delivery</button>
               <button id="razorpay-button" class="btn-primary">Pay with Razorpay</button>
               </label>
            </div>
            
            <!--<button type="submit" name="confirm_order" class="btn btn-primary">Confirm Order</button>-->
        </fieldset>
    </form>
    </div>
</section>
 <script>
    function toggleFields(forMyself){
        const fullNameField = document.getElementById('fullNameField');
        const fullNameInput = document.getElementById('fullName');

        if(forMyself){
            //show pre-filled fields for oredering for myself
            document.querySelector('input[name="contact"]').value = "<?php echo htmlspecialchars($user_contact);?>";
            document.querySelector('input[name="email"]').value = "<?php echo htmlspecialchars($user_email);?>";
            document.querySelector('textarea[name="address"]').value = "<?php echo htmlspecialchars($user_address);?>";
            fullNameField.style.display = 'none';
            fullNameInput.removeAttribute('required');
        }else{
            //show full name field for oredring for someone else
            fullNameField.style.display = 'block';
            fullNameInput.setAttribute('required','required');
            //clear pre-filled fields
            document.querySelector('input[name="contact"]').value = '';
            document.querySelector('input[name="email"]').value = '';
            document.querySelector('textarea[name="address"]').value = '';
            
        }
    }
    </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var totalAmount = <?php echo $cart_total; ?>;
    function setPaymentMode(mode) {
    document.getElementById('payment_mode').value = mode;
}

document.getElementById('razorpay-button').onclick = function(e){
    e.preventDefault();
   
    var form= document.getElementById('orderForm');

    if(!form.checkValidity()){
        form.reportValidity();
        return;
    }
    
    
    
    var options = {
        "key": "rzp_test_ZBIjyCh2OE2cGv",  // Replace with your Razorpay key
        "amount":totalAmount * 100, // Amount in paise
        "currency": "INR",
        "name": "Book Corner",
        "description": "Book Order Payment",
        "handler": function (response){
            document.getElementById('payment_mode').value = "Online"; // Set payment mode to "Online"
            var input = document.createElement("input");
        input.type = "hidden";
        input.name = "confirm_order";  // Same name as COD button
        input.value = "1";  
        document.getElementById('orderForm').appendChild(input);
            document.getElementById('orderForm').submit();
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    var rzp = new Razorpay(options);
    rzp.open();
};
 </script>
</body>
</html>