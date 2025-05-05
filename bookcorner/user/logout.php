
<?php
include('../config/constants.php');
unset($_SESSION['user_id']); 
unset($_SESSION['username']); 
header('location:'.SITEURL.'user/login.php');
exit();
?>