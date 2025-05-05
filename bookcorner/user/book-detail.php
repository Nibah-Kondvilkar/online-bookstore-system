<?php include('partials-front/menu.php'); ?>

<?php
// Check if book ID is set
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Fetch book details from database
    $sql = "SELECT * FROM tbl_books WHERE id = $book_id AND active = 'Yes'";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $copies_available = $row['copies_available'];
        $description = $row['description'];
        $image_name = $row['image_name'];
        $author = $row['author'];
        $genre_id = $row['genre_id']; // Assuming you have a genre_id column in tbl_books
    } else {
        echo "<div class='error text-center'>Book Not Found.</div>";
        exit;
    }
} else {
    echo "<div class='error text-center'>Invalid Access.</div>";
    exit;
}
?>

<section class="book-detail">
    <div class="container">
        <div class="book-detail-box">
            <div class="book-img">
                <?php if ($image_name == "") { ?>
                    <p class="error">Image Not Available</p>
                <?php } else { ?>
                    <img src="<?php echo SITEURL; ?>images/book/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                <?php } ?>
            </div>

            <div class="book-info">
               <h2><?php echo $title; ?></h2>
               <p class="author">By: <?php echo $author; ?></p>
               <p class="price">Price: ₹<?php echo $price; ?></p>
               <p class="stock">Available Stock: <?php echo $copies_available; ?></p>

              <?php if ($copies_available > 0) { ?>
                <form action="addto.php" method="POST">
                  <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                  <label for="quantity">Quantity:</label>
                  <input type="number" name="quantity" value="1" min="1" max="<?php echo $copies_available; ?>" required>
                  <input type="hidden" name="redirect_url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8'); ?>">
                   <button type="submit" name="addto" class="btn btn-primary">Add to Cart</button>
               </form>
              <?php } else { ?>
                <p class="out-of-stock" style="color: red; font-weight: bold;">Out of Stock</p>
              <?php } ?>

                <span class="book-description">
                    <h3>Description</h3>
                    <p><?php echo $description; ?></p>
                </span>
            </div>
        </div>
    </div>
</section>

<?php
      if(isset($_SESSION['modalMessage'])){
        $modalMessage = $_SESSION['modalMessage'];
        unset($_SESSION['modalMessage']);
       
      }
    ?>
    
    <!--Display the modal message-->
    <?php if (isset($modalMessage)) { ?>
    <div class="modal" style="display: block;">
        <div class="modal-content">
            <p><?php echo htmlspecialchars($modalMessage); ?></p>
            <form action="" method="POST">
                    <button type="submit" name="okbutton" value="submit" >OK</button>
            </form>
        </div>
    </div>
    <?php } ?>
    
<!-- Related Books Section -->
<section class="related-books">
    <div class="container">
        <h2>Related Books</h2>
        <br>
        <div class="related-books-box">
            <?php
            $sql_related = "SELECT * FROM tbl_books WHERE genre_id = $genre_id AND id != $book_id AND active = 'Yes' LIMIT 3";
            $res_related = mysqli_query($conn, $sql_related);

            if ($res_related && mysqli_num_rows($res_related) > 0) {
                while ($row_related = mysqli_fetch_assoc($res_related)) {
                    $related_id = $row_related['id'];
                    $related_title = $row_related['title'];
                    $related_price = $row_related['price'];
                    $related_author = $row_related['author'];
                    $related_image = $row_related['image_name'];
            ?>
                    <div class="related-book">
                        <a href="book-detail.php?book_id=<?php echo $related_id; ?>">
                            <div class="related-book-img">
                                <?php if ($related_image == "") { ?>
                                    <p class="error">Image Not Available</p>
                                <?php } else { ?>
                                    <img src="<?php echo SITEURL; ?>images/book/<?php echo $related_image; ?>" alt="<?php echo $related_title; ?>" class="img-responsive img-curve">
                                <?php } ?>
                            </div>
                            <div class="related-book-info">
                                <h4><?php echo $related_title; ?></h4>
                                <p class="price">₹<?php echo $related_price; ?></p>
                                <p class="author">By: <?php echo $related_author; ?></p>
                            </div>
                        </a>
                    </div>
            <?php
                }
            } else {
                echo "<p class='error'>No related books available.</p>";
            }
            ?>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>