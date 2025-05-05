<?php
include('../config/constants.php');
?>

<html>
<head>
    <title>Book Corner</title>
    <link rel="stylesheet" href="../css/user.css">
    <style>
        /* Dropdown Styling */
        .dropdown{
            position : relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            left:0;
            top:100%;
            background: white;
            min-width: 150px;
            max-width:200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            text-align: left;
            
            padding: 0;
            overflow: hidden;
        }
        .dropdown-content a {
            color: black;
            padding: 1px 10px;
            margin: 2px 0;
            line-height: 1.3;
            white-space: nowrap;
            font-size:16px;
            display: flex;
            min-height: 1px;
            text-decoration: none;
            border-bottom : 1px solid #ddd;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <img src="../images/Logo.jpeg" alt="bookcorner Logo" class="img-responsive">
            </div>

            <div class="menu text-right">
            <ul>
            <li><a href="index.php">Home</a></li>
            <li class="dropdown">
                <a href="#">Categories ⮟</a>
                <div class="dropdown-content">
                    <?php
                    $cat_sql = "SELECT * FROM tbl_genre WHERE active='Yes'";
                    $cat_res = mysqli_query($conn, $cat_sql);
                    while ($row = mysqli_fetch_assoc($cat_res)) {
                        echo '<a href="genre-books.php?genre_id='.$row['id'].'">'.$row['title'].'</a>';
                    }
                    ?>
                </div>
            </li>
            <li><a href="books.php">All Books</a></li>
            <?php if (isset($_SESSION['username'])) { ?>
                <li><a href="my-order.php">My Orders</a></li>
                <li><a href="cart.php">My Cart</a></li>
                <li><a href="about.php">About Us</a></li>
            <li><a href="contact-us.php">Contact Us</a></li>
                <li class="dropdown">
                    <a href="#">👤Hi, <?php echo $_SESSION['username']; ?> ⮟</a>
                    <div class="dropdown-content">
                        <a href="profile.php">Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </li>
            <?php } else { ?>
                <li><a href="about.php">About Us</a></li>
            <li><a href="contact-us.php">Contact Us</a></li>
                <li><a href="login.php">Login</a></li>
            <?php } ?>
        </ul>
    </div>
    <div class="clearfix"></div>
    </div>
     </section>