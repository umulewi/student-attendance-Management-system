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
// $sql_lec="select u.*, l.lecturer_id from users u join lecturer l on u.users_id= l.users_id where u.username= :username";
$sql_lec="SELECT lecturer_id from lecturer inner join users on lecturer.users_id= users.users_id where users.username =:username";

$stmt_lecturers = $pdo->prepare($sql_lec);
$stmt_lecturers->bindParam(':username', $username);
$stmt_lecturers->execute();
$lecturers = $stmt_lecturers->fetch(PDO::FETCH_ASSOC);
$lecturer_id= $lecturers['lecturer_id'];

$sql_lec2="SELECT * from lecturer_course inner join  course on lecturer_course.course_id= course.course_id where lecturer_course.lecturer_id=:lecturer_id";


$stmt_lecturers2 = $pdo->prepare($sql_lec2);
$stmt_lecturers2->bindParam(':lecturer_id', $lecturer_id);
$stmt_lecturers2->execute();
$lecturers2 = $stmt_lecturers2->fetch(PDO::FETCH_ASSOC);
$course_id= $lecturers2['course_id'];
$course_name= $lecturers2['course_name'];




// Fetch all students
$sql_students = "SELECT DISTINCT student.* FROM student JOIN student_course ON student.student_id = student_course.student_id JOIN course ON student_course.course_id = course.course_id JOIN lecturer_course ON course.course_id = lecturer_course.course_id JOIN lecturer ON lecturer_course.lecturer_id = lecturer.lecturer_id JOIN users ON lecturer.users_id = users.users_id JOIN institution AS student_institution ON student.institution_id = student_institution.institution_id JOIN institution AS lecturer_institution ON lecturer.institution_id = lecturer_institution.institution_id WHERE course.course_name =:course_name AND users.username = :username AND student_institution.institution_id = lecturer_institution.institution_id ORDER BY student.student_name";

$stmt_students = $pdo->prepare($sql_students);
$stmt_students->bindParam(':username', $username);
$stmt_students->bindParam(':course_name', $course_name);
$stmt_students->execute();
$students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($students as $student) {
        $student_id = $student['student_id'];
        $created_by=$username;
        $date = date('Y-m-d');

        
       
        $attendance_value = isset($_POST['attendance_' . $student_id]) ? 1 : 0;

        // Insert attendance record into the database
        $sql_insert = "INSERT INTO student_attendance (student_id,course_id, attentance,lecturer_id,created_by,date) VALUES (:student_id,:course_id, :attendance_value, :lecturer_id,:created_by,:date)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindParam(':student_id', $student_id);
        $stmt_insert->bindParam(':attendance_value', $attendance_value);
        $stmt_insert->bindParam(':lecturer_id', $lecturer_id);
        $stmt_insert->bindParam(':course_id', $course_id);
        $stmt_insert->bindParam(':created_by', $created_by);
        $stmt_insert->bindParam(':date', $date);
        $stmt_insert->execute();
    }
}
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
<form method="POST"> <!-- Form to submit attendance data -->
    <table>
        <thead>
            <tr>
            <th>No</th>
                <th>Student Name</th>
                <th>Reg No</th>
                <th>Attendance</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            $x=1;
            foreach ($students as $student) {
                echo "<tr>";
                echo "<td>".$x."</td>";
                echo "<td>" . $student['student_name'] . "</td>";
               
                echo "<td>" . $student['reg_no'] . "</td>";
                echo "<td><input type='checkbox' name='attendance_" . $student['student_id'] . "'></td>"; // Checkbox column
                echo "</tr>";
                $x=$x+1;
            }
          
            ?>
        </tbody>
    </table>
    <button type="submit" class="btn" style="background-color:teal">Submit Attendance</button>
</form>

</body>
</html>
