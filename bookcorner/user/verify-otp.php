<?php
include('../config/constants.php');

// Initialize variables for modal display
$showModal = false;
$modalMessage = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if OTP and username are provided
    if (isset($_POST['otp']) && isset($_POST['username'])) {
        $enteredOtp = $_POST['otp'];
        $username = $_POST['username'];

        // Check if the OTP matches and hasn't expired
        if (isset($_SESSION['otp']) && $_SESSION['otp'] == $enteredOtp && time() < $_SESSION['otp_expiry']) {
            // OTP is valid, proceed to allow password reset
            $modalMessage = "OTP verified successfully!";
            //  redirect to the password reset form here
            header('Location: reset-pwd.php');
            exit(); 
        } else {
            // OTP is invalid or expired
            $showModal = true;
            $modalMessage = "Invalid or expired OTP.";
            
        }
    } else {
        // Handle missing OTP or username
        $showModal = true;
        $modalMessage = "OTP or username missing.";
    }
} else {
    // If not POST, check if username is in the query string
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
    } else {
        $showModal = true;
        $modalMessage = "Username missing.";
    }
}
?>

<html>
<head>
    <title>Verify OTP</title>
    <link rel="stylesheet" href="../css/user.css">
</head>
<body style="background-image: url('../images/book.jpeg');">
    <div class="lgcontainer">
        <h2>Verify OTP</h2>

        <!-- OTP verification form -->
        <form action="" method="POST">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <label for="otp">Enter OTP:</label><br>
            <input type="text" id="otp" name="otp" placeholder="Enter the OTP" required><br><br>
            <button type="submit">Verify OTP</button>
        </form>
    </div>

    <!-- Modal for showing messages -->
    <div class="modal <?php echo $showModal ? 'show' : ''; ?>">
        <div class="modal-content">
            <p><?php echo htmlspecialchars($modalMessage); ?></p>
            <form action="" method="POST">
                <button type="button" onclick="window.location.href='forgot-pwd.php'">OK</button>
            </form>
        </div>
    </div>
</body>
</html>