<?php
include('../config/constants.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

// Initialize variables for modal display
$showModal = false;
$modalMessage = '';
$username = '';
$new_password = '';
$confirm_password ='';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
    $new_password = isset($_POST['new_password']) ? mysqli_real_escape_string($conn, $_POST['new_password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? mysqli_real_escape_string($conn, $_POST['confirm_password']) : '';

    // Check if new password and confirm password match
    if ($new_password === $confirm_password) {
        $hashedPassword = md5($new_password); // Use md5 to hash the password

        // Update the password in the database
        $sql = "UPDATE tbl_user SET password='$hashedPassword' WHERE username='$username'";
        $res = mysqli_query($conn, $sql);

        // Check if the query was successful
        if ($res) {
            $showModal = true;
            $modalMessage = "Password has been reset successfully!";
        } else {
            $showModal = true;
            $modalMessage = "Failed to reset password. Please try again.";
        }
    } else {
        $showModal = true;
        $modalMessage = "New password and confirm password do not match.";
    }
}
//check if ok button is clicked
if(isset($_POST['closeModal'])){
    header("Location: login.php");
    exit();
}
?>

<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="../css/user.css">
</head>
<body style="background-image: url('../images/book.jpeg');">
    <div class="lgcontainer">
        <h2>Reset Password</h2>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required><br>
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="must contain one number one lowercase and uppercase letter,and atleast 8 or more character" required><br>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="must contain one number one lowercase and uppercase letter,and atleast 8 or more character" required><br>
            <button type="submit">Reset Password</button>
        </form>
    </div>

    <!-- Modal for showing messages -->
    <div class="modal <?php echo $showModal ? 'show' : ''; ?>">
        <div class="modal-content">
            <p><?php echo htmlspecialchars($modalMessage); ?></p>
            <form action="" method="POST">
                <button type="submit" name="closeModal">OK</button>
            </form>
        </div>
    </div>
</body>
</html>