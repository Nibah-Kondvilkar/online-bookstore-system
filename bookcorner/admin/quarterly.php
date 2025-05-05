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
            <h2><b>Quarterly Sales Report</b></h2>
            <br><br><br>

            <form action="" method="GET">
                <label for="quarter">Select Quarter:</label>
                <select name="quarter" id="quarter" onchange="this.form.submit()">
                    <option value="">Select Quarter</option>
                    <option value="1" <?php if(isset($_GET['quarter']) && $_GET['quarter']== '1') echo 'selected';?>>(Apr-Jun) Q1</option>
                    <option value="2" <?php if(isset($_GET['quarter']) && $_GET['quarter']== '2') echo 'selected';?>>(Jul-sep) Q2</option>
                    <option value="3" <?php if(isset($_GET['quarter']) && $_GET['quarter']== '3') echo 'selected';?>>(Oct-Dec) Q3</option>
                    <option value="4" <?php if(isset($_GET['quarter']) && $_GET['quarter']== '4') echo 'selected';?>>(Jan-Mar) Q4</option>
                </select>
            </form>
            <br>
            <?php
            $i=1;
            if(isset($_GET['quarter']) && !empty($_GET['quarter'])){
                $quarter = $_GET['quarter'];

                //define the month ranges for each quarter 
                switch($quarter){
                    case '1':
                        $start_month = '04';//april
                        $end_month = '06';//june
                        break;
                    case '2':
                        $start_month = '07';
                        $end_month = '09';
                        break;
                    case '3':
                        $start_month = '10';
                        $end_month = '12';
                        break;
                    case '4':
                        $start_month = '01';//jan
                        $end_month = '03';//mar
                        break;
                }

                //sql query to get total sales for selected quarter
                if($quarter == '4'){
                    $sql = "SELECT CONCAT(YEAR(order_date)-1, '-', YEAR(order_date))AS year_range,
                    SUM(total) AS quarterly_sales
                    FROM tbl_order
                    WHERE paid = 'Yes'
                    AND (DATE_FORMAT(order_date, '%m') >= '$start_month' OR DATE_FORMAT(order_date, '%m') <= '$end_month')
                    GROUP BY CONCAT(YEAR(order_date) - 1, '-', YEAR(order_date))";
                }else{
                      $sql = "SELECT CONCAT(YEAR(order_date), '-Q', $quarter)AS quarter_name,
                        SUM(total) As quarterly_sales
                        FROM tbl_order
                        WHERE paid = 'Yes'
                        AND DATE_FORMAT(order_date, '%m') BETWEEN '$start_month' AND '$end_month'
                        GROUP BY YEAR(order_date)";
                    }
                $res = mysqli_query($conn, $sql);
                if($res && mysqli_num_rows($res)>0){
                    $row = mysqli_fetch_assoc($res);
        
            ?>
            <table class="tbl-80">
                <tr>
                    <th>S.N</th>
                    <th>Quarter</th>
                    <th>Total Sales</th>
                </tr>
                <tr>
                    <td><?php echo $i++;?></td>
                    <td><?php echo ($quarter == '4') ? $row['year_range'] . "Q4" : $row['quarter_name'];?></td>
                    <td>₹<?php echo number_format($row['quarterly_sales'], 2);?></td>
                </tr>
            </table>
            <br><br><br>
            <form>
            <button type="button" class="no-print btn-report" onclick="window.print()">Print Report</button>
            </form>
            <br><br>
            <?php
                }else{
                    echo "<tr><td colspan='5' class='text-center'><strong>No Sales Data Found for the selected Quarter.</strong></td></tr>";
                }
            }
            ?>
            </div>
    </div>   
</body>
</html>