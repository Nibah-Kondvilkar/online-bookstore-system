<?php
include('../config/constants.php');
unset($_SESSION['admin_id']); // Unset only admin session
unset($_SESSION['admin_username']); // Unset other admin-related session variables if needed
header('location:'.SITEURL.'admin/login.php');
exit();
?>