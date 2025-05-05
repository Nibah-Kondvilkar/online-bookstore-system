<?php 
include('../config/constants.php');
include('login-check.php');
ob_start();

// Get the logged-in admin username
$admin_username = isset($_SESSION['user']) ? $_SESSION['user'] : 'Admin';
?>

<html>
<head>
    <title>Book Corner</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        /* Dropdown container */
        .dropdown {
            position: relative;
        }

        /* Dropdown button */
        .dropdown > a {
            cursor: pointer;
        }

        /* Dropdown content */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 180px;
            right: 0;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            text-align: left;
            z-index: 10;
        }

        /* Dropdown links */
        .dropdown-content a {
            color: black;
            padding: 10px;
            text-decoration: none;
            display: block;
            font-size: 14px;
        }

        /* Hover effect */
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Show dropdown when clicked */
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Menu Section Start -->
    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="manage-admin.php">Admin</a></li>
                <li><a href="manage-user.php">Users</a></li>
                <li><a href="manage-books.php">Books</a></li>
                <li><a href="manage-genre.php">Genre</a></li>
                <li><a href="manage-supplier.php">Suppliers</a></li>
                <li><a href="manage-order.php">Orders</a></li>
                <li><a href="report.php">Reports</a></li>
                
                <!-- Logout Dropdown -->
                <li class="dropdown">
                    <a>Logout ⮟</a>
                    <div class="dropdown-content">
                        <a href="#">Hi, <?php echo $admin_username; ?></a>
                        <a href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- Menu Section Ends -->
</body>
</html>