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


<?php
// Pagination
$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Total number of orders
$total_sql = "SELECT COUNT(*) AS total FROM tbl_books";
$total_res = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_res);
$total_orders = $total_row['total'];
$total_pages = ceil($total_orders / $limit);
// Fetch all books
$sql = "SELECT * FROM tbl_books WHERE active='Yes' LIMIT $limit OFFSET $offset";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

$sn = $offset + 1;
?>

<!-- Books Listing -->
<section class="shop-books">
    <div class="container">
        <h2 class="text-beige text-center">All Books</h2>

        <?php
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $book_id = $row['id'];
                $title = $row['title'];
                $author = $row['author'];  
                $price = $row['price'];
                $description = $row['description'];
                $copies_available = $row['copies_available'];
                $image_name = $row['image_name'];

                // Limit description to two lines
                $short_description = strlen($description) > 100 ? substr($description, 0, 95) . "..." : $description;
        ?>
                <div class="book-box">
                    <div class="book-img">
                        <?php if ($image_name != "") { ?>
                            <img src="<?php echo SITEURL; ?>images/book/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                        <?php } else { ?>
                            <div class='error'>Image Not Available</div>
                        <?php } ?>
                    </div>
                    <div class="book-details">
                        <h4><?php echo $title; ?></h4>
                        <p class="book-author"><strong>By:</strong> <?php echo $author; ?></p> 
                        <p class="book-price">₹<?php echo $price; ?></p>
                        <span class="book-detail"><small><?php echo $short_description; ?></small></span>

                        
                        <div>
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
                </div>
        <?php
            }
        } else {
            echo "<div class='error'>No books available</div>";
        }
        ?>

        <div class="clearfix"></div>
        <!--pagination-->
        <?php if ($total_pages > 1) : ?>
    <div class="pagination">
    <!-- Previous arrow -->
    <a href="?page=<?php echo max(1, $page - 1); ?>" 
       class="prev <?php if ($page == 1) echo 'disabled'; ?>" 
       <?php if ($page == 1) echo 'style="pointer-events: none; opacity: 0.5;"'; ?>>
        &#10094;
    </a>

    <!-- First page link -->
    <a href="?page=1" class="<?php if ($page == 1) echo 'active'; ?>">1</a>

    <!-- Show ellipsis if needed before current range -->
    <?php if ($page > 3 && $total_pages > 3) : ?>
        <span>...</span>
    <?php endif; ?>

    <!-- Dynamic page links based on current page -->
    <?php
    for ($i = max(2, $page - 1); $i <= min($page + 1, $total_pages - 1); $i++) {
        echo "<a href='?page=$i' class='" . ($i == $page ? 'active' : '') . "'>$i</a>";
    }
    ?>

    <!-- Show ellipsis if needed after current range -->
    <?php if ($page < $total_pages - 2 && $total_pages > 3) : ?>
        <span>...</span>
    <?php endif; ?>

    <!-- Last page link -->
    <?php if ($total_pages > 1) : ?>
        <a href="?page=<?php echo $total_pages; ?>" 
           class="<?php if ($page == $total_pages) echo 'active'; ?>">
            <?php echo $total_pages; ?>
        </a>
    <?php endif; ?>

    <!-- Next arrow -->
    <a href="?page=<?php echo min($total_pages, $page + 1); ?>" 
       class="next <?php if ($page == $total_pages) echo 'disabled'; ?>" 
       <?php if ($page == $total_pages) echo 'style="pointer-events: none; opacity: 0.5;"'; ?>>
        &#10095;
    </a>
</div>
<?php endif; ?>
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

<?php include('partials-front/footer.php'); ?>