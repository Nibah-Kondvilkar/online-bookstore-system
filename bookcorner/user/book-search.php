<?php include('partials-front/menu.php'); ?>

<!-- Book Search Section -->
<section class="book-search text-center">
    <div class="container">
        <?php
        // Get the search keyword
        $search = '';
        if (isset($_POST['search'])) {
            $search = mysqli_real_escape_string($conn, $_POST['search']);
            $_SESSION['search'] = $search;
        } elseif (isset($_SESSION['search'])) {
            $search = $_SESSION['search'];
        }
        ?>
        <h2 class="text-beige ">Books Matching Your Search: <a href="#" class="text-beige ">"<?php echo $search; ?>"</a></h2>
    </div>
</section>
<!-- End of Book Search Section -->

<!-- Check for Modal Message -->
<?php
if (isset($_SESSION['modalMessage'])) {
    $modalMessage = $_SESSION['modalMessage'];
    unset($_SESSION['modalMessage']);
}
?>

<!-- Display Modal Message -->
<?php if (isset($modalMessage)) { ?>
    <div class="modal" style="display: block;">
        <div class="modal-content">
            <p><?php echo htmlspecialchars($modalMessage); ?></p>
            <form action="" method="POST">
                <button type="submit" name="okbutton" value="submit">OK</button>
            </form>
        </div>
    </div>
<?php } ?>

<!-- Book Shop Section -->
<section class="shop-books">
    <div class="container">
        <h2 class="text-center">Shop Books</h2>

        <?php
        // SQL query to get books based on search keyword
        $sql = "SELECT tbl_books.*, tbl_genre.title AS genre_title 
        FROM tbl_books 
        LEFT JOIN tbl_genre ON tbl_books.genre_id = tbl_genre.id
        WHERE tbl_books.title LIKE '%$search%' 
        OR tbl_genre.title LIKE '%$search%' 
        OR tbl_books.author LIKE '%$search%'";
        $res = mysqli_query($conn, $sql);

        // Count rows
        $count = mysqli_num_rows($res);

        // Check if books are available
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                // Get book details
                $book_id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $description = $row['description'];
                $image_name = $row['image_name'];
                $author = $row['author'];

                $short_description = strlen($description) > 100 ? substr($description, 0, 95) . "..." : $description;
        ?>
                <div class="book-box">
                    <div class="book-img">
                        <?php
                        // Check if the image is available
                        if ($image_name == "") {
                            echo "<div class='error'>Image Not Available</div>";
                        } else {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/book/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve"><br>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="book-details">
                        <h4><?php echo $title; ?></h4>
                        <p class="book-author"><strong>By:</strong> <?php echo $author; ?></p>
                        <p class="book-price">₹<?php echo $price; ?></p>
                        <span class="book-detail"><small><?php echo $short_description; ?></small></span>

                        <a href="<?php echo SITEURL; ?>user/book-detail.php?book_id=<?php echo $book_id; ?>"  class="btn btn-primary">View</a>

                        <form action="addto.php" method="POST" class="inline-form">
                            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                            <input type="number" name="quantity" value="1" min="1" required>
                            <input type="hidden" name="redirect_url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8'); ?>">
                            <button type="submit" name="addto" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<div class='error'>No books found matching your search.</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- End of Book Shop Section -->

<?php include('partials-front/footer.php'); ?>