<?php include('partials-front/menu.php'); ?>

<?php
// Check if genre ID is provided
if (isset($_GET['genre_id'])) {
    $genre_id = mysqli_real_escape_string($conn, $_GET['genre_id']);

    // Fetch genre title
    $genre_query = "SELECT title FROM tbl_genre WHERE id = '$genre_id'";
    $genre_res = mysqli_query($conn, $genre_query);
    $genre_row = mysqli_fetch_assoc($genre_res);
    $genre_title = $genre_row ? $genre_row['title'] : "Books";

    // Fetch books from the selected genre
    $sql = "SELECT * FROM tbl_books WHERE genre_id = '$genre_id' AND active='Yes'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
} else {
    header("Location: index.php"); // Redirect if no genre is selected
    exit();
}
?>

<!--check for modal message-->
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
    
<!-- Genre Heading Section with Background -->
<section class="book-search text-center" >
    <div class="container">
        <h2 class="text-beige ">Books in <span class="text-beige ">"<?php echo $genre_title; ?>"</span></h2>
    </div>
</section>

<!-- Books Listing -->
<section class="shop-books">
    <div class="container">

        <?php
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $book_id = $row['id'];
                $title = $row['title'];
                $author = $row['author'];  // Fetch author
                $price = $row['price'];
                $description = $row['description'];
                $copies_available = $row['copies_available'];
                $image_name = $row['image_name'];

                $short_description = strlen($description) > 100 ? substr($description, 0, 95) . "..." : $description;
        ?>
                <div class="book-box">
                <div class="book-img">
                        <?php if ($image_name != "") { ?>
                            <img src="<?php echo SITEURL; ?>images/book/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                        <?php } else {
                            echo "<div class='error'>Image Not Available</div>";
                        } ?>
                    </div>
                    <div class="book-details">
                        <h4><?php echo $title; ?></h4>
                        <p class="book-author"><strong>By:</strong> <?php echo $author; ?></p> 
                        <p class="book-price">₹<?php echo $price; ?></p>
                        <span class="book-detail"><small><?php echo $short_description; ?></small></span>
                        <a href="<?php echo SITEURL; ?>user/book-detail.php?book_id=<?php echo $book_id; ?>"  class="btn btn-primary">View</a>
                       <?php if ($copies_available > 0) { ?>
                      <form action="addto.php" method="POST" class="inline-form">
                        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                        <input type="number" name="quantity" value="1" min="1" max="<?php echo $copies_available; ?>" required>
                        <input type="hidden" name="redirect_url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8'); ?>">
                        <button type="submit" name="addto" class="btn btn-primary">Add to Cart</button>
                      </form>
                      <?php } else { ?>
                      <p class="out-of-stock" style="color: red; font-weight: bold;">Out of Stock</p>
                         <?php } ?>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<div class='error'>No books found in this genre</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>