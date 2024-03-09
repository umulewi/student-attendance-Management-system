

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:../index.php");
    exit; // Ensure to stop script execution after redirection
}

include '../connection.php';

include'dashboard.php';

 // Include database connection

// Check if student_id is provided via GET request


$student_id = $_GET['student_id'];
// Fetch student details using prepared statement
$stmt_student = $pdo->prepare("SELECT * FROM student WHERE student_id = :student_id");
$stmt_student->execute(['student_id' => $student_id]);
$student = $stmt_student->fetch(PDO::FETCH_ASSOC);
$institution_id = $student['institution_id'];

$stmt_course = $pdo->prepare("SELECT * FROM course WHERE institution_id = :institution_id");
$stmt_course->execute(['institution_id' => $institution_id]);
$courses = $stmt_course->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student Course</title>
    <style>
        /* Form container */
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        /* Form fields */
        .form-container div {
            margin-bottom: 15px;
        }
        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-container input[type="text"],
        .form-container input[type="password"],
        form select,
        .form-container input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; 
        }


        .form-container input[type="submit"] {
            width: 20%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: teal;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: teal;
        }
    </style>

    
</head>
<body>
    <h2 style="text-align:center">Add Student Course</h2><br>
    <div class="form-container">
        <form action="" method="post">
            <div>
                <label for="name">Reg Number:</label>
                <input type="text" name="reg_no" value="<?php echo $student['reg_no']; ?>" required readonly>
            </div>
            <div>
                <label for="physical_code">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $student['email']; ?>" required readonly>
            </div>
            <div>
                <label for="phone">Student Name:</label>
                <input type="text" id="student_name" name="student_name" value="<?php echo $student['student_name']; ?>" required readonly>
            </div>
            <div>
                <label for="institution">Courses:</label>
                <select id="institution" name="institution" required>
                    <option value="">All courses</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <input type="submit" name="add" value="ADD" style="background-color: teal;">
            </div>
        </form>
    </div>
</body>
</html>

<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['institution'])) {
        $course_id = $_POST['institution'];
        $student_id = $_GET['student_id'];

        // Insert student course using prepared statement
        $stmt_student_course = $pdo->prepare("INSERT INTO student_course (student_id, course_id) VALUES (:student_id, :course_id)");
        try {
            $stmt_student_course->execute(['student_id' => $student_id, 'course_id' => $course_id]);
            echo "New student course has been added successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Error: Course is not selected.";
    }
}
?>
