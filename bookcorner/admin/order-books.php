<?php include('partials/menu.php'); ?>

<div class="main-content text-center">
    <div class="wrapper">
        <h1>Order Book</h1>
        <br/><br/>
        <?php
        if(isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>

        <form id="orderForm" action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Book Title: </td>
                    <td>
                        <input type="text" name="book_title" placeholder="Enter Book Title">
                        <br>or
                        <select name="selected_book">
                            <option value="" disabled selected>Select Book</option>
                            <?php
                            $sql_books = "SELECT title FROM tbl_books";
                            $res_books = mysqli_query($conn, $sql_books);

                            if ($res_books && mysqli_num_rows($res_books) > 0) {
                                while ($row_books = mysqli_fetch_assoc($res_books)) {
                                    echo "<option value='" . $row_books['title'] . "'>" . $row_books['title'] . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Books Available</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Supplier: </td>
                    <td>
                        <select name="supplier_id" required>
                            <option value="">--Select Supplier--</option>
                            <?php
                            $sql_suppliers = "SELECT id, full_name FROM tbl_supplier";
                            $res_suppliers = mysqli_query($conn, $sql_suppliers);
                            while ($supplier = mysqli_fetch_assoc($res_suppliers)) {
                                echo "<option value='{$supplier['id']}'>{$supplier['full_name']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Quantity: </td>
                    <td><input type="number" name="quantity" required min="1"></td>
                </tr>

                <tr>
                    <td>Payment Amount: </td>
                    <td><input type="number" name="payment_amount" required min="100"></td>
                </tr>

                <input type="hidden" name="payment_mode" id="payment_mode">
                
                <tr>
                    <td>Payment Mode: </td>
                    <td>
                        <button type="submit" class="btn-primary" onclick="setPaymentMode('COD')">Cash on Delivery</button>
                        <button id="razorpay-button" class="btn-secondary">Pay with Razorpay</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_title = !empty($_POST['book_title']) ? mysqli_real_escape_string($conn, $_POST['book_title']) : 
                 (isset($_POST['selected_book']) ? mysqli_real_escape_string($conn, $_POST['selected_book']) : '');

    $supplier_id = mysqli_real_escape_string($conn, $_POST['supplier_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $payment_amount = mysqli_real_escape_string($conn, $_POST['payment_amount']);
    $payment_mode = mysqli_real_escape_string($conn, $_POST['payment_mode']);
    $order_date = date("Y-m-d H:i:s");

    if (empty($book_title)) {
        echo "<div class='error'>Book title is required!</div>";
    } else {
        $sql = "INSERT INTO tbl_supplier_books (book_title, supplier_id, quantity, payment_mode, payment_amount, order_date) 
                VALUES ('$book_title', '$supplier_id', '$quantity', '$payment_mode', '$payment_amount', '$order_date')";

        $res = mysqli_query($conn, $sql);

        if ($res) {
            $_SESSION['add'] = "<div class='success'>Book Ordered Successfully</div>";
            header("location:".SITEURL.'admin/manage-books.php');
        } else {
            $_SESSION['add'] = "<div class='error'>Failed To Order Book</div>";
            header("location:".SITEURL.'admin/order-books.php');
        }
    }
}
?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
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
    
    var paymentAmount = document.querySelector("input[name='payment_amount']").value;
    
    var options = {
        "key": "abc",  // Replace with your Razorpay key
        "amount": paymentAmount * 100, // Amount in paise
        "currency": "INR",
        "name": "Book Corner",
        "description": "Book Order Payment",
        "handler": function (response){
            document.getElementById('payment_mode').value = "Online"; // Set payment mode to "Online"
            document.getElementById('orderForm').submit();
        },
        "prefill": {
            "name": "Nibah", 
            "email": "your email"
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    var rzp = new Razorpay(options);
    rzp.open();
};
</script>

<?php include('partials/footer.php'); ?>
