<?php
include('../config/constants.php');
$showModal = true;
if (!isset($_SESSION['order_status'])) {
    echo "not set";
    //header('Location: cart.php');
    exit();
}

$order_status = $_SESSION['order_status'];
unset($_SESSION['order_status']);
?>

<html>
<head>
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="../css/user.css">
</head>
<body>
    <div class="modal  <?php echo  $showModal ? 'show' : '';?>">
        <div class="modal-content">
            <p><?php echo htmlspecialchars($order_status); ?></p>
            <form method="POST" action="index.php">
                <button type="submit" name="ok_button">OK</button>
            </form>
        </div>
    </div>
</body>
</html>