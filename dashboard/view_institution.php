<?php  
session_start();
if (!isset($_SESSION['username'])) {
 header("location:../index.php");
}
 ?>

<?php
include'dashboard.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: teal;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
        }
        .btn.delete {
            background-color: crimson;
        }
        .btn.update {
            background-color: #b0b435;
        }
    </style>
</head>
<body>
<?php
include '../connection.php';

?>


    <center><h5 style="color:teal;margin-top:2rem">List Of All Institution</h5></center>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>PHYSICAL CODE</th>
            <th>EMAIL</th>
            <th>PHONE</th>
            <th>CREATED BY</th>
            <th>CREATED ON</th>
            <th>UPDATED BY</th>
            <th>UPDATED BY</th>
            <th>ACTION</th>
        </tr>
        <?php 
        $i=1;
        $stmt = $pdo->query("SELECT * FROM institution");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['name'];?></td>
            <td><?php echo $row['physical_code'];?></td>
            <td><?php echo $row['email'];?></td>
            <td><?php echo $row['phone'];?></td>
            <td><?php echo $row['created_by'];?></td>
            <td><?php echo $row['created_on'];?></td>
            <td><?php echo $row['updated_by'];?></td>
            <td><?php echo $row['updated_on'];?></td>
            <td style="width: -56rem">
            <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="institution_update.php?institution_id=<?php echo $row['institution_id'];?>"><b>Update</b></a>
           
            </td>
        </tr>
        <?php
$i++;
    }

        ?>
</table>
</span>

</body>
</html>