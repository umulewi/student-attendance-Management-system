
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
    exit();
}
?>
<?php

include '../connection.php';
include 'dashboard.php';
$username = $_SESSION['username'];
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

<h2 style="margin-top:2rem;text-align:center">All Student</h2>
<table>
    <thead>
        <tr>
        <th>ID</th>
            <th>Student Name</th>
            <th>Reg No</th>
            
            
            
        </tr>
    </thead>
    <tbody>
        <?php
        $sql =" SELECT DISTINCT student.* FROM student JOIN student_course ON student.student_id = student_course.student_id JOIN course ON student_course.course_id = course.course_id JOIN lecturer_course ON course.course_id = lecturer_course.course_id JOIN lecturer ON lecturer_course.lecturer_id = lecturer.lecturer_id JOIN users ON lecturer.users_id = users.users_id JOIN institution AS student_institution ON student.institution_id = student_institution.institution_id JOIN institution AS lecturer_institution ON lecturer.institution_id = lecturer_institution.institution_id WHERE users.username =:username AND student_institution.institution_id = lecturer_institution.institution_id ORDER BY student.student_name;";


        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$i=1;
        foreach ($results as $result) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $result['student_name'] . "</td>";
            
            echo "<td>" . $result['reg_no'] . "</td>";
        
           

           
            echo "</tr>";
            $i=$i+1;
        }
        ?>
    </tbody>
</table>

</body>
</html>
