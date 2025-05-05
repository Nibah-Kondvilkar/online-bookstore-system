<?php include('partials-front/menu.php');
?>

<!-- Book search section -->
<section class="book-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>user/book-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for books..." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- End of book search section -->


<!-- Shop Books Section -->
<section class="shop-books">
    <div class="container">
        <h2 class="text-center">Shop Books</h2>

        <?php
        // Fetch books from the database
        $sql = "SELECT * FROM tbl_books WHERE active='Yes' LIMIT 12";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $book_id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $author = $row['author'];
                $image_name = $row['image_name'];
                ?>
                <div class="book-box">
                    <div class="book-img">
                        <?php if ($image_name == "") { ?>
                            <div class="error">Image Not Available</div>
                        <?php } else { ?>
                            <img src="<?php echo SITEURL; ?>images/book/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                        <?php } ?>
                    </div>
                    <div class="book-details">
                        <h4><?php echo $title; ?></h4>
                        <p class="book-price">₹<?php echo $price; ?></p>
                        <p class="book-author">By: <?php echo $author; ?></p>
                        <a href="<?php echo SITEURL; ?>user/book-detail.php?book_id=<?php echo $book_id; ?>"  class="btn btn-primary">View</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='error'>No Books Available</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- End of Shop Books Section -->

<?php include('partials-front/footer.php'); ?>