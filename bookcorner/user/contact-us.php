<?php
//include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

include('partials-front/menu.php');

// Default empty
$full_name = "";
$email = "";

// Get logged-in user info
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $res = mysqli_query($conn, "SELECT full_name, email FROM tbl_user WHERE id = $user_id");
    if ($res && mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $full_name = $row['full_name'];
        $email = $row['email'];
    }
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<div id="contact-page">
    <div class="container2">
        <h1 class="heading">Contact Us</h1>
        <br><br>

        <div class="contact-info">
            <p><strong>Address:</strong><br>
            Nasheman Colony,<br>
             Dapoli.</p>
            <p><strong>Phone:</strong><br>9763797874</p>
            <p><strong>Email:</strong><br>info@bookcorner.com</p>
            <p class="follow-us"><strong>Follow Us On:</strong></p>
            <div class="social-media">
                <a href="#"><i class="fab fa-facebook-f"></i>Facebook</a>
                <a href="#"><i class="fab fa-twitter"></i>Twitter</a>
                <a href="#"><i class="fab fa-instagram"></i>Instagram</a>
            </div>
        </div>

        <div class="contact-form">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['ok'])) {
                $name = htmlspecialchars($_POST['name']);
                $email = htmlspecialchars($_POST['email']);
                $message = htmlspecialchars($_POST['message']);

                // PHPMailer setup to send an email to yourself
                $mail = new PHPMailer(true);
                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'kondvilkarnibah@gmail.com'; // My Gmail
                    $mail->Password = 'ubtw gyvu eneq pwhf';   //  Gmail App password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    // Recipients
                    $mail->setFrom($email, $name);
                    $mail->addAddress('kondvilkarnibah@gmail.com'); //  email to receive the feedback

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Customer Feedback';
                    $mail->Body = "<strong>Name:</strong> $name<br>
                                   <strong>Email:</strong> $email<br>
                                   <strong>Message:</strong><br>$message";

                    // Send the email
                    if ($mail->send()) {
                        echo "<div class='message-box-overlay'>";
                        echo "<div class='message-box'>";
                        echo "<p>Thank you, $name. Your message has been sent successfully.</p>";
                        echo "<a href='contact-us.php' class='ok-button'>OK</a>";
                        echo "</div>";
                        echo "</div>";
                    } else {
                        echo "<p>Sorry, we couldn't send your message. Please try again later.</p>";
                    }
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
            ?>
            <form method="post" action="">
                <input type="text" name="name" placeholder="Full Name" value="<?php echo htmlspecialchars($full_name); ?>" required oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" required>
                <textarea name="message" placeholder="Type your Message..." required></textarea>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
            <?php } ?>
        </div>
    </div>
</div> <!-- End of contact page div -->



<?php
// Include the footer
include('partials-front/footer.php');
?>