<?php include('partials/menu.php'); ?>
<head>
    <style>
        @media print {
            .no-print, .menu, .footer {
                display: none;
            }
        }
    </style>
</head>
<div class="main-content text-center">
    <div class="wrapper">
        <h1>Book Information</h1>
        <br>
        <?php
        if (isset($_GET['id'])) {
            $supplier_id = $_GET['id'];

            // Fetch supplier name
            $supplier_query = mysqli_query($conn, "SELECT full_name FROM tbl_supplier WHERE id = '$supplier_id'");
            if ($supplier_query && mysqli_num_rows($supplier_query) > 0) {
                $supplier_name = mysqli_fetch_assoc($supplier_query)['full_name'];
                echo "<h1>Supplier: $supplier_name</h1>";
            } else {
                echo "<div class='error'>Supplier not found.</div>";
                exit;
            }

            // Fetch book order data
            $sql = "SELECT sb.book_title, sb.quantity, sb.order_date, sb.payment_mode, sb.payment_amount
                    FROM tbl_supplier_books sb
                    WHERE sb.supplier_id = '$supplier_id'
                    ORDER BY sb.order_date DESC";
            $res = mysqli_query($conn, $sql);

            if ($res && mysqli_num_rows($res) > 0) {
                echo "<table class='tbl-full'>
                      <tr>
                          <th>S.N</th>
                          <th>Book Title</th>
                          <th>Quantity</th>
                          <th>Order Date</th>
                          <th>Payment Mode</th>
                          <th>Payment Amount</th>
                      </tr>";

                $sn = 1;
                $total_quantity = 0;
                $total_payment = 0;

                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                          <td>" . $sn++ . "</td>
                          <td>" . $row['book_title'] . "</td>
                          <td>" . $row['quantity'] . "</td>
                          <td>" . $row['order_date'] . "</td>
                          <td>" . $row['payment_mode'] . "</td>
                          <td>₹" . $row['payment_amount'] . "</td>
                          </tr>";

                    // Add to total quantity and payment
                    $total_quantity += $row['quantity'];
                    $total_payment += $row['payment_amount'];
                }

                // Display totals
                echo "<tr>
                        <td colspan='2' style='text-align:right; font-size:20px;'><b>Total:</b></td>
                        <td style='font-size:18px;'><b>$total_quantity</b></td>
                        <td colspan='2'></td>
                        <td style='font-size:18px;'><b>₹$total_payment</b></td>
                      </tr>";

                echo "</table>";
            } else {
                echo "<div class='error'>No book orders found for this supplier.</div>";
            }
        } else {
            echo "<div class='error'>Invalid request. No supplier ID provided.</div>";
        }
        ?>
        <br>
        <form>
            <button type="button" class="no-print btn-report" onclick="window.print()">Print Report</button>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>