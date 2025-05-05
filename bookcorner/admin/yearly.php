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
            <h2><b>Yearly Sales Report</b></h2>
            <br><br><br>

            <form action="" method="GET">
                <label for="year">Select Year:</label>
                <select name="year" id="year" onchange="this.form.submit()">
                    <option value="">Select Year</option>
                    <?php
                    //fetch distinct years from the orders table
                    $sql_years ="SELECT DISTINCT YEAR(order_date) AS year FROM tbl_order ORDER BY year DESC";
                    $res_years = mysqli_query($conn,$sql_years);
                    if($res_years && mysqli_num_rows($res_years)>0){
                        while($row_year = mysqli_fetch_assoc($res_years)){
                            echo"<option value='" .$row_year['year'] . "'>" . $row_year['year'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </form>
            <br>
            <?php
            $i=1;
            if(isset($_GET['year']) && $_GET['year'] !=''){
                $selected_year = $_GET['year'];

                //query to fetch the total sales for the selected year
                $sql_sales = "SELECT
                             YEAR(order_date) AS year_name,
                             SUM(total) As yearly_sales
                             FROM tbl_order
                             WHERE YEAR(order_date) = '$selected_year' AND paid = 'Yes'
                             GROUP BY YEAR(order_date)";

                $res_sales = mysqli_query($conn, $sql_sales);
                if($res_sales && mysqli_num_rows($res_sales)>0){
                    $row_sales = mysqli_fetch_assoc($res_sales);
        
            ?>
            <table class="tbl-80">
                <tr>
                    <th>S.N</th>
                    <th>Year</th>
                    <th>Total Sales</th>
                </tr>
                <tr>
                    <td><?php echo $i++;?></td>
                    <td><?php echo $row_sales['year_name'];?></td>
                    <td>₹<?php echo number_format($row_sales['yearly_sales'], 2);?></td>
                </tr>
            </table>
            <br><br><br>
            <form>
            <button type="button" class="no-print btn-report" onclick="window.print()">Print Report</button>
            </form>
            <br><br>
            <?php
                }else{
                    echo "<tr><td colspan='5' class='text-center'><strong>No Sales Data Found for the selected year.</strong></td></tr>";
                }
            }
            ?>
            </div>
    </div>   
</body>
</html>