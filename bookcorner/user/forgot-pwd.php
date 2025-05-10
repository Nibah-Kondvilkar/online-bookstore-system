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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if both username and email are provided
    if (isset($_POST['username']) && isset($_POST['email'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        
        // Check if user exists in the database
        $sql = "SELECT * FROM tbl_user WHERE username='$username' AND email='$email'";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
            // User exists, generate an OTP
            $otp = rand(100000, 999999); // 6-digit OTP
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_expiry'] = time() + 300; // OTP expires in 5 minutes
            $_SESSION['username'] = $username;

            // Send OTP email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username   = '//';  // Your Gmail
                $mail->Password   = '//';    // App Password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('//email', 'Book Corner');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Your OTP for Password Reset';
                $mail->Body = "Hello $username,<br>Your OTP is <b>$otp</b>. It will expire in 5 minutes.<br>Best regards,<br>Book Corner";

                $mail->send();

                // Set the modal to be shown
                $showModal = true;
                $modalMessage = "An OTP has been sent to $email. Please check your inbox to verify your identity.";
            } catch (Exception $e) {
                $showModal = true;
                $modalMessage = "Error sending the OTP: {$mail->ErrorInfo}";
            }
        } else {
            // No user found
            $showModal = true;
            $modalMessage = "No account found with that username and email.";
        }
    } else {
        // Handle missing fields
        $showModal = true;
        $modalMessage = "Please provide both username and email.";
    }
}
?>

<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/user.css">
</head>
<body style="background-image: url('../images/book.jpeg');">
    <div class="lgcontainer">
        <h2>Forgot Password</h2>

        <!-- Forgot password form -->
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required><br><br>
            <button type="submit">Send OTP</button>
        </form>
    </div>

    <!-- Modal for showing messages -->
    <div class="modal <?php echo $showModal ? 'show' : ''; ?>">
        <div class="modal-content">
            <p><?php echo htmlspecialchars($modalMessage); ?></p>
            <form action="" method="POST">
                <!-- Redirect to the OTP verification page -->
                <button type="button" onclick="window.location.href='verify-otp.php?username=<?php echo urlencode($username); ?>'">OK</button>
            </form>
        </div>
    </div>
</body>
</html>
