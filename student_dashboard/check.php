<?php
session_start();
include '../connection.php';
include'dashboard.php';
$username = $_SESSION['username'];

$sql = "SELECT course.course_name
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

echo "<h2>Courses enrolled:</h2>";
foreach ($results as $result) {
    echo "<p>" . $result['course_name'] . "</p>";
}
?>
