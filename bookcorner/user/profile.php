<?php 
include('partials-front/menu.php'); 

//include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$modalMessage = '';
$showModal = false;

// Fetch user details
$sql = "SELECT * FROM tbl_user WHERE id = '$user_id'";
$res = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($res);

// Handle profile update
if (isset($_POST['update_profile'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Track updated fields
    $updatedFields = "";
    if ($user['full_name'] != $full_name) {
        $updatedFields .= "Full Name: " . $user['full_name'] . " → " . $full_name . "<br>";
    }
    if ($user['username'] != $username) {
        $updatedFields .= "User Name: " . $user['username'] . " → " . $username . "<br>";
    }
    if ($user['contact'] != $contact) {
        $updatedFields .= "Contact: " . $user['contact'] . " → " . $contact . "<br>";
    }
    if ($user['email'] != $email) {
        $updatedFields .= "Email: " . $user['email'] . " → " . $email . "<br>";
    }
    if ($user['address'] != $address) {
        $updatedFields .= "Address: " . $user['address'] . " → " . $address . "<br>";
    }

    // Update database only if changes were made
    if (!empty($updatedFields)) {
        $sql = "UPDATE tbl_user SET full_name='$full_name', username='$username', contact='$contact', email='$email', address='$address' WHERE id='$user_id'";
        if (mysqli_query($conn, $sql)) {
            $modalMessage = "Profile updated successfully!";
            $showModal = true;
            
            //include PHPMailer
              
              require '../phpmailer/src/Exception.php';
               require '../phpmailer/src/PHPMailer.php';
              require '../phpmailer/src/SMTP.php';

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'your email';  // Your email
                $mail->Password = 'your pass';    // Your app password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('//your email', 'Book Corner');
                $mail->addAddress($email, $full_name);

                $mail->isHTML(true);
                $mail->Subject = 'Profile Update Notification';
                $mail->Body = "Hi $full_name,<br>Your profile details have been updated successfully.<br><br>
                               <strong>Updated Fields:</strong><br>$updatedFields<br>
                               <br>Best regards,<br>Book Corner Team";

                $mail->send();
            } catch (Exception $e) {}
        }
    } else {
        $modalMessage = "No changes detected!";
        $showModal = true;
    }
}

// Handle password update
if (isset($_POST['update_password'])) {
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check current password
    if (md5($current_password) === ($user['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_password = md5($new_password);
            $sql = "UPDATE tbl_user SET password='$hashed_password' WHERE id='$user_id'";
            if (mysqli_query($conn, $sql)) {
                $modalMessage = "Password updated successfully!";
                $showModal = true;

                require '../phpmailer/src/Exception.php';
               require '../phpmailer/src/PHPMailer.php';
              require '../phpmailer/src/SMTP.php';
                // Send Email Notification for Password Change
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'email';  // Your email
                    $mail->Password = 'pass';    // Your app password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('email', 'Book Corner');
                    $mail->addAddress($user['email'], $user['full_name']);

                    $mail->isHTML(true);
                    $mail->Subject = 'Password Update Notification';
                    $mail->Body = "Hi " . $user['full_name'] . ",<br><br>Your password has been successfully updated.<br>
                                  If you did not make this change, please contact support immediately.<br><br>
                                  Best regards,<br>Book Corner Team";

                    $mail->send();
                } catch (Exception $e) {}
            }
        } else {
            $modalMessage = "New password and confirm password do not match!";
            $showModal = true;
        }
    } else {
        $modalMessage = "Incorrect current password!";
        $showModal = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="../css/user.css">
</head>
<body>
    <div class="profile-container">
        <h2>My Profile</h2>
        <form class="profile-form" method="POST">
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
            
            <label>User Name</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label>Contact</label>
            <input type="text" name="contact" pattern="[789][0-9]{9}" maxlength="10" placeholder="E.g. 9015xxxxxx" class="input-responsive" value="<?php echo htmlspecialchars($user['contact']); ?>" required oninput="this.value = this.value.replace(/\D/g, ''); if (this.value.length === 1 && !/[789]/.test(this.value)) {
            this.value = '';}this.value = this.value.slice(0, 10);">

            <label>Email</label>
            <input type="email" name="email" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label>Address</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>

            <button type="submit" name="update_profile" class="btn-update">Update Profile</button>
        </form>
    </div>

    <div class="profile-container">
        <h2>Change Password</h2>
        <form class="profile-form" method="POST">
            <label>Current Password</label>
            <input type="password" name="current_password" required>

            <label>New Password</label>
            <input type="password" name="new_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="must contain one number one lowercase and uppercase letter,and atleast 8 or more character" required>

            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="must contain one number one lowercase and uppercase letter,and atleast 8 or more character" required>

            <button type="submit" name="update_password" class="btn-update">Change Password</button>
        </form>
    </div>

    <!-- Modal Message -->
    <div class="modal <?php echo $showModal ? 'show' : ''; ?>">
        <div class="modal-content">
            <p><?php echo htmlspecialchars($modalMessage); ?></p>
            <form method="POST">
                <button type="submit" name="okbutton">OK</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php include('partials-front/footer.php'); ?>
