<?php  
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
    exit();
}
?>

<?php

include '../connection.php';
include  'dashboard.php';

$username = $_SESSION['username'];

$sql_lec = "SELECT lecturer_id FROM lecturer INNER JOIN users ON lecturer.users_id = users.users_id WHERE users.username = :username";
$stmt_lec = $pdo->prepare($sql_lec);
$stmt_lec->bindParam(':username', $username);
$stmt_lec->execute();
$lecturer = $stmt_lec->fetch(PDO::FETCH_ASSOC);
$lecturer_id = $lecturer['lecturer_id'];

$sql_course = "SELECT *  FROM lecturer_course INNER JOIN course ON lecturer_course.course_id = course.course_id WHERE lecturer_id = :lecturer_id";
$stmt_course = $pdo->prepare($sql_course);
$stmt_course->bindParam(':lecturer_id', $lecturer_id);
$stmt_course->execute();
$course = $stmt_course->fetch(PDO::FETCH_ASSOC); // Fetch a single row instead of fetching all
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
            <th>Student Name</th>
            <?php
            foreach ($dates as $date) {
                echo "<th>{$date['date']}</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php

        $sql_students = "SELECT DISTINCT student.student_id, student.student_name FROM student JOIN student_course ON student.student_id = student_course.student_id JOIN course ON student_course.course_id = course.course_id JOIN lecturer_course ON course.course_id = lecturer_course.course_id WHERE lecturer_course.lecturer_id = :lecturer_id AND course.course_id = :course_id";
        $stmt_students = $pdo->prepare($sql_students);
        $stmt_students->bindParam(':lecturer_id', $lecturer_id);
        $stmt_students->bindParam(':course_id', $course_id);
        $stmt_students->execute();
        $students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);


        foreach ($students as $student) {
            echo "<tr>";
            echo "<td>{$student['student_name']}</td>";
            foreach ($dates as $date) {

                $sql_attendance = "SELECT attentance FROM student_attendance WHERE student_id = :student_id AND course_id = :course_id AND date = :date";
                $stmt_attendance = $pdo->prepare($sql_attendance);
                $stmt_attendance->bindParam(':student_id', $student['student_id']);
                $stmt_attendance->bindParam(':course_id', $course_id);
                $stmt_attendance->bindParam(':date', $date['date']);
                $stmt_attendance->execute();
                $attendance = $stmt_attendance->fetchColumn(); // Fetching a single value (attendance) directly
                echo "<td>" . ($attendance == 1 ? 'Present' : 'Absent') . "</td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
