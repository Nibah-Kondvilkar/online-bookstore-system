<?php include('../config/constants.php');?>
<?php
    $i=1;
    $sql = "SELECT
    DATE(order_date) AS order_date,
    DATE_FORMAT(order_date, '%Y-%m')AS month,
    SUM(total) AS daily_sales
    FROM
     tbl_order 
     WHERE
      paid = 'Yes'
     GROUP BY
      DATE(order_date), DATE_FORMAT(order_date, '%Y-%m')
     ORDER BY
      DATE(order_date) DESC;
    ";
    $res = mysqli_query($conn, $sql);
    if($res && mysqli_num_rows($res)>0){

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        @media print{
            .no-print{
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="main-content text-center">
        <div class="wrapper">
            <h2><b>Daily Sales Report</b></h2>
            <br><br><br>
            <table class="tbl-80">
            <tr>
              <th>S.N</th>
              <th>Sales Date</th>
              <th>Daily</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($res)) {?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row['order_date'];?></td>
                <td>₹<?php echo number_format($row['daily_sales'], 2);?></td>
            </tr>
            <?php } ?>
            </table>
            <br><br><br>
            <form>
            <button type="button" class="no-print btn-report" onclick="window.print()">Print Report</button>
            </form>
            <br><br>
            <?php
                }else{
                    echo "<tr><td colspan='5' class='text-center'><strong>No Sales Data Found</strong></td></tr>";
                }         
            ?>
       </div>
    </div>   
</body>
</html>
