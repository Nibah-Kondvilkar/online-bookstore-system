<?php include('../config/constants.php');?>
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
            <h2><b>Monthly Sales Report</b></h2>
            <br><br><br>

            <form action="" method="GET">
                <label for="month">Select Month:</label>
                <select name="month" id="month" onchange="this.form.submit()">
                    <option value="">Select Month</option>
                    <option value="01" <?php if(isset($_GET['month']) && $_GET['month']== '01') echo 'selected';?>>January</option>
                    <option value="02" <?php if(isset($_GET['month']) && $_GET['month']== '02') echo 'selected';?>>February</option>
                    <option value="03" <?php if(isset($_GET['month']) && $_GET['month']== '03') echo 'selected';?>>March</option>
                    <option value="04" <?php if(isset($_GET['month']) && $_GET['month']== '04') echo 'selected';?>>April</option>
                    <option value="05" <?php if(isset($_GET['month']) && $_GET['month']== '05') echo 'selected';?>>May</option>
                    <option value="06" <?php if(isset($_GET['month']) && $_GET['month']== '06') echo 'selected';?>>June</option>
                    <option value="07" <?php if(isset($_GET['month']) && $_GET['month']== '07') echo 'selected';?>>July</option>
                    <option value="08" <?php if(isset($_GET['month']) && $_GET['month']== '08') echo 'selected';?>>August</option>
                    <option value="09" <?php if(isset($_GET['month']) && $_GET['month']== '09') echo 'selected';?>>September</option>
                    <option value="10" <?php if(isset($_GET['month']) && $_GET['month']== '10') echo 'selected';?>>Octobor</option>
                    <option value="11" <?php if(isset($_GET['month']) && $_GET['month']== '11') echo 'selected';?>>November</option>
                    <option value="12" <?php if(isset($_GET['month']) && $_GET['month']== '12') echo 'selected';?>>December</option>
                </select>
            </form>
            <br>
            <?php
            $i=1;
            if(isset($_GET['month']) && !empty($_GET['month'])){
                $month = $_GET['month'];

                //query to fetch the total sales for the selected month
                $sql = "SELECT
                        DATE_FORMAT(order_date, '%M %Y') AS month_name,
                         SUM(total) As monthly_sales
                        FROM tbl_order
                        WHERE paid = 'Yes' AND DATE_FORMAT(order_date, '%m') = '$month'
                        GROUP BY DATE_FORMAT(order_date, '%Y-%m')";

                $res = mysqli_query($conn, $sql);
                if($res && mysqli_num_rows($res)>0){
                    $row = mysqli_fetch_assoc($res);
        
            ?>
            <table class="tbl-80">
                <tr>
                    <th>S.N</th>
                    <th>Month</th>
                    <th>Total Sales</th>
                </tr>
                <tr>
                    <td><?php echo $i++;?></td>
                    <td><?php echo $row['month_name'];?></td>
                    <td>₹<?php echo number_format($row['monthly_sales'], 2);?></td>
                </tr>
            </table>
            <br><br><br>
            <form>
            <button type="button" class="no-print btn-report" onclick="window.print()">Print Report</button>
            </form>
            <br><br>
            <?php
                }else{
                    echo "<tr><td colspan='5' class='text-center'><strong>No Sales Data Found for the selected Month.</strong></td></tr>";
                }
            }
            ?>
            </div>
    </div>   
</body>
</html>