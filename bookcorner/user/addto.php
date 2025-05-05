<?php
include('../config/constants.php');
$showModal = false;
$modalMessage = '';
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['addto'])) {
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    //get the price
    $price_sql = "SELECT price FROM tbl_books WHERE id = '$book_id'";
    $price_res = mysqli_query($conn,$price_sql);
    $price_row = mysqli_fetch_assoc($price_res);
    $price = $price_row['price'];
    
    //calculate the total price
    $total_price = $price * $quantity;

    //get book name
    $book_sql = "SELECT title FROM tbl_books WHERE id = '$book_id'";
    $book_res = mysqli_query($conn,$book_sql);
    $book_row = mysqli_fetch_assoc($book_res);
    $book_name = mysqli_real_escape_string($conn, $book_row['title']);
    $redirectUrl = $_POST['redirect_url'];

    $redirectUrl = '/' .ltrim($redirectUrl, '/');
    

    // Check if item is already in the cart
    $check_sql = "SELECT * FROM tbl_cart WHERE user_id = '$user_id' AND book_id = '$book_id'";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        // Update quantity if item is already in the cart
        $update_sql = "UPDATE tbl_cart SET quantity = quantity + '$quantity', total_price = total_price +'$total_price'  WHERE user_id = '$user_id' AND book_id = '$book_id'";
        mysqli_query($conn, $update_sql);
    } else {
        // Insert new item into the cart
        $sql = "INSERT INTO tbl_cart (user_id, book_id,title, price, quantity, total_price) VALUES ('$user_id', '$book_id','$book_name','$price', '$quantity', '$total_price')";
        mysqli_query($conn, $sql);
    }

    // show modal message and redirect
    //modal message with the book name
    $_SESSION['modalMessage'] = "$book_name added to cart";
    $_SESSION['showModal'] = true;
    header("Location:" .htmlspecialchars($redirectUrl, ENT_QUOTES, 'UTF-8'));
    exit();
}
?>



   