<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
    exit();
}
include '../connection.php';
include  'dashboard.php';

$username = $_SESSION['username'];

$sql_lec = "SELECT * FROM student INNER JOIN users ON student.users_id = users.users_id WHERE users.username = :username";
$stmt_lec = $pdo->prepare($sql_lec);
$stmt_lec->bindParam(':username', $username);
$stmt_lec->execute();
$student = $stmt_lec->fetch(PDO::FETCH_ASSOC);
$student_id = $student['student_id'];
$student_name = $student['student_name'];

$sql_course = "SELECT *  FROM student_course INNER JOIN course ON student_course.course_id = course.course_id WHERE student_id = :student_id";
$stmt_course = $pdo->prepare($sql_course);
$stmt_course->bindParam(':student_id', $student_id);
$stmt_course->execute();
$course = $stmt_course->fetch(PDO::FETCH_ASSOC);
$course_id = $course['course_id'];
$course_name = $course['course_name'];

$sql_dates = "SELECT DISTINCT date FROM student_attendance WHERE course_id = :course_id ORDER BY date";
$stmt_dates = $pdo->prepare($sql_dates);
$stmt_dates->bindParam(':course_id', $course_id);
$stmt_dates->execute();
$dates = $stmt_dates->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <style>
        table {
            width: auto;
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
    </style>
</head>
<body>

<h2 style="margin-top: 2rem; text-align: center;">Attendance</h2>
<table>
    <thead>
        <tr>
           
            <!--<th>Student Name</th>-->
            <th>Username</th> 
            
            <?php
            foreach ($dates as $date) {
                echo "<th>{$date['date']}</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
    <?php



$sql_students = "SELECT DISTINCT student_id FROM student_attendance WHERE student_id = :student_id";
$stmt_students = $pdo->prepare($sql_students);
$stmt_students->bindParam(':student_id', $student_id);
$stmt_students->execute();
$students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

$attendance_records = []; // Array to store attendance records

// Fetch all attendance records for each student
foreach ($students as $student) {
    $sql_attendance = "SELECT date, attentance FROM student_attendance WHERE student_id = :student_id";
    $stmt_attendance = $pdo->prepare($sql_attendance);
    $stmt_attendance->bindParam(':student_id', $student['student_id']);
    $stmt_attendance->execute();
    $attendance_records[$student['student_id']] = $stmt_attendance->fetchAll(PDO::FETCH_ASSOC);
}

// Display attendance for each student and date
foreach ($students as $student) {
    echo "<tr>";
    //echo "<td>{$student['student_id']}</td>";
    //echo "<td>{$student['student_name']}</td>";
    echo "<td>{$username}</td>"; 
    foreach ($dates as $date) {
        $attendance = 'Absent'; // Default value
        
        // Check if attendance record exists for this date and student
        if (isset($attendance_records[$student['student_id']])) {
            foreach ($attendance_records[$student['student_id']] as $record) {
                if ($record['date'] == $date['date']) {
                    $attendance = $record['attentance'] == 1 ? 'Present' : 'Absent';
                    break;
                }
            }
        }

        echo "<td>{$attendance}</td>";
    }
    echo "</tr>";
}
?>

    </tbody>
</table>

</body>
</html>
