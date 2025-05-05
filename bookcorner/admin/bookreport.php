<?php include('../config/constants.php'); ?>
<?php
  $i = 1;

  // Get Top 5 Most Ordered Books
  $sql_most_ordered = "SELECT b.id, b.title, b.author, g.title AS genre, b.copies_available, 
                               SUM(CAST(o.quantity AS UNSIGNED)) AS total_ordered
                        FROM tbl_books b
                        INNER JOIN tbl_genre g ON b.genre_id = g.id
                        INNER JOIN tbl_order o ON FIND_IN_SET(b.title, o.orders) > 0
                        GROUP BY b.id
                        HAVING total_ordered > 0
                        ORDER BY total_ordered DESC
                        LIMIT 5";
  $res_most_ordered = mysqli_query($conn, $sql_most_ordered);

  // Get total books available
  $sql_total_books = "SELECT SUM(copies_available) AS total_books FROM tbl_books";
  $res_total_books = mysqli_query($conn, $sql_total_books);
  $total_books = mysqli_fetch_assoc($res_total_books)['total_books'];

  // Fix: Properly count all quantities
  $sql_total_orders = "SELECT SUM(
      IF(LOCATE(',', quantity) > 0, 
         (LENGTH(quantity) - LENGTH(REPLACE(quantity, ',', '')) + 1), 
         CAST(quantity AS UNSIGNED))
  ) AS total_orders FROM tbl_order WHERE quantity IS NOT NULL AND TRIM(quantity) <> ''";
  $res_total_orders = mysqli_query($conn, $sql_total_orders);
  $total_orders = mysqli_fetch_assoc($res_total_orders)['total_orders'];

  // Get Low Stock Books (Less than 5 copies)
  $sql_low_stock = "SELECT id, title, author, copies_available FROM tbl_books WHERE copies_available < 4";
  $res_low_stock = mysqli_query($conn, $sql_low_stock);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="main-content text-center">
        <div class="wrapper">
            <h2><b>Books Report</b></h2>
            <br><br>

            <h3>Total Books in Store: <?php echo $total_books; ?></h3>
            <h3>Total Orders Placed: <?php echo $total_orders; ?></h3>

            <br><br>
            <h3>Top 5 Most Ordered Books</h3>
            <table class="tbl-80">
                <tr>
                    <th>S.N</th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Copies Available</th>
                    <th>Total Ordered</th>
                </tr>
                <?php if(mysqli_num_rows($res_most_ordered) > 0) { ?>
                    <?php while($row = mysqli_fetch_assoc($res_most_ordered)) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['author']; ?></td>
                            <td><?php echo $row['genre']; ?></td>
                            <td><?php echo $row['copies_available']; ?></td>
                            <td><?php echo $row['total_ordered']; ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan='7' class='text-center'><strong>No Orders Found</strong></td>
                    </tr>
                <?php } ?>
            </table>

            <br><br>
            <h3>Low Stock Alert (Less than 4 Copies Available)</h3>
            <table class="tbl-80">
                <tr>
                    <th>S.N</th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Copies Available</th>
                </tr>
                <?php $i = 1; ?>
                <?php if(mysqli_num_rows($res_low_stock) > 0) { ?>
                    <?php while($row = mysqli_fetch_assoc($res_low_stock)) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['author']; ?></td>
                            <td style="color: red; font-weight: bold;"><?php echo $row['copies_available']; ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan='5' class='text-center'><strong>No Low Stock Books</strong></td>
                    </tr>
                <?php } ?>
            </table>

            <br><br><br>
            <form>
                <button type="button" class="no-print btn-report" onclick="window.print()">Print Report</button>
            </form>
            <br><br>
       </div>
    </div>   
</body>
</html>