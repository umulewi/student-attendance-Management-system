<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
    exit();
}
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

<h2 style="margin-top:2rem;text-align:center">All Lectures</h2>
<table>
    <thead>
        <tr>
            <th>lecturer Name</th>
            
            
        </tr>
    </thead>
    <tbody>
        
    
    <?php
$sql = "SELECT * FROM users JOIN student ON users.users_id = student.users_id WHERE users.username=:username";
$stmt2 = $pdo->prepare($sql);
$stmt2->bindParam(':username', $username);
$stmt2->execute();
$institution_id = $stmt2->fetch(PDO::FETCH_ASSOC);
$inst = $institution_id['institution_id'];
$student_id = $institution_id['student_id'];

// Select course_id
$sql3 = "SELECT * FROM student JOIN student_course ON student.student_id = student_course.student_id WHERE student.student_id=:student_id";
$stmt3 = $pdo->prepare($sql3);
$stmt3->bindParam(':student_id', $student_id);
$stmt3->execute();
$course_id = $stmt3->fetch(PDO::FETCH_ASSOC);

// $sql2 = "SELECT distinct  lecturer.* FROM lecturer 
//          inner JOIN lecturer_course ON lecturer.lecturer_id = lecturer_course.lecturer_id 
//          inner JOIN course ON lecturer_course.course_id = course.course_id 
//          inner JOIN student_course ON student_course.course_id = course.course_id 
//          WHERE lecturer.institution_id=:institution_id AND course.course_id=:course_id";

$sql2= "SELECT DISTINCT lecturer.* FROM lecturer JOIN lecturer_course ON lecturer.lecturer_id = lecturer_course.lecturer_id JOIN course ON lecturer_course.course_id = course.course_id JOIN student_course ON student_course.course_id = course.course_id WHERE lecturer.institution_id=:institution_id AND course.course_id IN (:course_id)";

$stmt = $pdo->prepare($sql2);
$stmt->bindParam(':institution_id', $inst);
// Bind the specific value from $course_id array
$stmt->bindParam(':course_id', $course_id['course_id']);

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $result) {
    echo "<tr>";
    echo "<td>" . $result['lecturer_name'] . "</td>";

  
    echo "</tr>";
}
?>

    </tbody>
</table>

</body>
</html>
