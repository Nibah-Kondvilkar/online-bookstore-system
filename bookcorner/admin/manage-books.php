<?php include('partials/menu.php'); ?>

<div class="main-content text-center">
    <div class="wrapper">
        <!-- Search Section with Dropdown -->
        <section class="search1">
            <form action="" method="POST">
                <select name="search_by" required>
                    <option value="title">Search by Book Title</option>
                    <option value="author">Search by Author</option>
                    <option value="genre">Search by Genre</option>
                </select>
                <input type="search" name="search" placeholder="Enter your search..." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>
        </section>

        <h1>Manage Books</h1>
        <br><br>

        <!-- Button to Add Book -->
        <div style="display: flex; justify-content: center; align-items: center; position: relative;">
            <a href="<?php echo SITEURL; ?>admin/add-book.php" class="btn-primary">Add Book</a>
            <div style="position: absolute; right: 0; display: flex; gap: 8px;">
                <a href="<?php echo SITEURL; ?>admin/order-books.php" class="btn-primary" style="margin-right: 10px; padding: 10px 15px;">Order Book</a>
            </div>
        </div>
        <br>

        <?php
        // Display session messages (if any)
        $session_messages = ['add', 'delete', 'upload', 'remove-failed', 'unauthorized', 'update'];
        foreach ($session_messages as $msg) {
            if (isset($_SESSION[$msg])) {
                echo $_SESSION[$msg];
                unset($_SESSION[$msg]);
            }
        }

        // Define pagination variables
        $limit = 5;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Check if a search was performed
        if (isset($_POST['submit'])) {
            $search = mysqli_real_escape_string($conn, $_POST['search']);
            $search_by = $_POST['search_by']; // Get selected search filter

            // Determine the SQL query based on search criteria
            if ($search_by == "title") {
                $sql = "SELECT b.*, g.title AS genre_title
                        FROM tbl_books b
                        LEFT JOIN tbl_genre g ON b.genre_id = g.id
                        WHERE b.title LIKE '%$search%'
                        LIMIT $offset, $limit";
            } elseif ($search_by == "author") {
                $sql = "SELECT b.*, g.title AS genre_title
                        FROM tbl_books b
                        LEFT JOIN tbl_genre g ON b.genre_id = g.id
                        WHERE b.author LIKE '%$search%'
                        LIMIT $offset, $limit";
            } elseif ($search_by == "genre") {
                $sql = "SELECT b.*, g.title AS genre_title
                        FROM tbl_books b
                        LEFT JOIN tbl_genre g ON b.genre_id = g.id
                        WHERE g.title LIKE '%$search%'
                        LIMIT $offset, $limit";
            }
        } else {
            // Default query for book listing with pagination
            $sql = "SELECT b.*, g.title AS genre_title
                    FROM tbl_books b
                    LEFT JOIN tbl_genre g ON b.genre_id = g.id
                    LIMIT $offset, $limit";
        }

        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Genre</th>
                <th>Image</th>
                <th>Available Copies</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            if ($count > 0) {
                $sn = $offset + 1;
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $author = $row['author'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $copies_available = $row['copies_available'];
                    $active = $row['active'];
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $author; ?></td>
                        <td>₹<?php echo $price; ?></td>
                        <td><?php echo $row['genre_title']; ?></td>
                        <td>
                            <?php if ($image_name == "") {
                                echo "<div class='error'>Image not Added</div>";
                            } else { ?>
                                <img src="<?php echo SITEURL; ?>images/book/<?php echo $image_name; ?>" width="80px">
                            <?php } ?>
                        </td>
                        <td><?php echo $copies_available; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-book.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary">Update</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-book.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='9' class='error'>No books found.</td></tr>";
            }
            ?>
        </table>

        <!-- Pagination -->
        <?php
        // Get total number of books
        $sql_count = "SELECT COUNT(*) AS total FROM tbl_books";
        $res_count = mysqli_query($conn, $sql_count);
        $row_count = mysqli_fetch_assoc($res_count);
        $total_rows = $row_count['total'];
        $total_pages = ceil($total_rows / $limit);

        if ($total_pages > 1) : ?>
            <div class="pagination">
                <a href="?page=<?php echo max(1, $page - 1); ?>" class="prev <?php if ($page == 1) echo 'disabled'; ?>" 
                   <?php if ($page == 1) echo 'style="pointer-events: none; opacity: 0.5;"'; ?>>&#10094;</a>

                <a href="?page=1" class="<?php if ($page == 1) echo 'active'; ?>">1</a>

                <?php if ($page > 3 && $total_pages > 3) : ?><span>...</span><?php endif; ?>

                <?php for ($i = max(2, $page - 1); $i <= min($page + 1, $total_pages - 1); $i++) {
                    echo "<a href='?page=$i' class='" . ($i == $page ? 'active' : '') . "'>$i</a>";
                } ?>

                <?php if ($page < $total_pages - 2 && $total_pages > 3) : ?><span>...</span><?php endif; ?>

                <?php if ($total_pages > 1) : ?>
                    <a href="?page=<?php echo $total_pages; ?>" class="<?php if ($page == $total_pages) echo 'active'; ?>">
                        <?php echo $total_pages; ?>
                    </a>
                <?php endif; ?>

                <a href="?page=<?php echo min($total_pages, $page + 1); ?>" class="next <?php if ($page == $total_pages) echo 'disabled'; ?>" 
                   <?php if ($page == $total_pages) echo 'style="pointer-events: none; opacity: 0.5;"'; ?>>&#10095;</a>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>