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
$sql = "SELECT course.*, institution.name AS institution_name
        FROM course
        INNER JOIN institution ON course.institution_id = institution.institution_id"; // Assuming there's a column in student table corresponding to username
$stmt = $pdo->query($sql);
$users="select username from users";
?>
<h2 style="margin-top:2rem;text-align:center">List of all courses</h2>
<table class="table">
    <tr>
        <th>ID</th>
        <th>course_name</th>
        <th>Course code</th>
        <th>Institution Names</th>
        <th>Created By</th>
        <th>Created On</th>
        <th>Updated By</th>
        <th>Updated On</th>
        <th>Action</th>
    </tr>
    <?php 
    $i=1;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
    <tr>
        <td><?php echo $i;?></td>
        <td><?php echo $row['course_name'];?></td>
        <td><?php echo $row['course_code'];?></td>
        <td><?php echo $row['institution_name'];?></td>
        <td><?php echo $row['created_by'];?></td>
        <td><?php echo $row['created_on'];?></td>
        <td><?php echo $row['updated_by'];?></td>
        <td><?php echo $row['updated_on'];?></td>
        <td>
            <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="course_update.php?course_id=<?php echo $row['course_id'];?>"><b>Update</b></a>
        </td>
    </tr>
    <?php 
$i++; } ?>

</table>
</span>

</body>
</html>