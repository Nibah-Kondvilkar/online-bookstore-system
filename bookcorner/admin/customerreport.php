<?php include('../config/constants.php');?>
<?php
  $i=1;
  $sql = "SELECT id, full_name, username, contact, email,created_at
  FROM tbl_user
  ORDER BY created_at DESC";
  $res=mysqli_query($conn,$sql);
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
            <h2><b>Customers Report</b></h2>
            <br><br><br>
            <table class="tbl-80">
            <tr>
              <th>S.N</th>
              <th>ID</th>
              <th>Customer Name</th>
              <th>Customer Username</th>
              <th>Customer Contact</th>
              <th>Customer Email</th>
              <th>Account Created At</th>
            </tr>
            <?php if(mysqli_num_rows($res)>0) { ?>
            <?php while($row = mysqli_fetch_assoc($res)) {?>
            <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row['id'];?></td>
                <td><?php echo $row['full_name'];?></td>
                <td><?php echo $row['username'];?></td>
                <td><?php echo $row['contact'];?></td>
                <td><?php echo $row['email'];?></td>
                <td><?php echo $row['created_at'];?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan='5' class='text-center'><strong>No Customer Data Found</strong></td>
                </tr>
            <?php }?>
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