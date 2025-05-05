<?php include('partials/menu.php'); ?>
<div class="main-content text-center">
    <div class="wrapper">
        <h1>Reports</h1>
         <br><br><br>
         <table class="tbl-50">
            <tr>
              <th>S.N</th>
              <th>Reports</th>
              <th>View</th>
            </tr>
            <tr>
                <td>1.</td>
                <td>Sales Report</td>
                <td>
                <a href="<?php echo SITEURL;?>admin/daily.php" class="btn-report">Daily</a>
                <a href="<?php echo SITEURL;?>admin/monthly.php" class="btn-report">Monthly</a>
                <a href="<?php echo SITEURL;?>admin/quarterly.php" class="btn-report">Quarterly</a>
                <a href="<?php echo SITEURL;?>admin/yearly.php" class="btn-report">Yearly</a>
                </td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Customers Report</td>
                <td><a href="<?php echo SITEURL;?>admin/customerreport.php" class="btn-report">View</a></td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Books Report</td>
                <td><a href="<?php echo SITEURL;?>admin/bookreport.php" class="btn-report">View</a></td>
            </tr>
         <div class="clearfix"></div>
        </table>
        <br><br>
    </div>
</div>

<?php include('partials/footer.php'); ?>