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

<h2 style="margin-top:2rem;text-align:center">Courses Enrolled</h2>
<table>
    <thead>
        <tr>
            <th>Course Name</th>
            <th>Course Code</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT course.course_id, course.course_name,course.course_code
                FROM course
                JOIN (
                    SELECT student_course.course_id
                    FROM student_course
                    JOIN student ON student_course.student_id = student.student_id
                    JOIN users ON student.users_id = users.users_id
                    WHERE users.username = :username
                    GROUP BY student_course.course_id
                ) AS filtered_courses ON course.course_id = filtered_courses.course_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) {
            echo "<tr>";
            echo "<td>" . $result['course_name'] . "</td>";
            echo "<td>" . $result['course_code'] . "</td>";
           
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
