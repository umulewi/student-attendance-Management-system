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

<?php
include '../connection.php'; 
$stmt = $pdo->query("SELECT * FROM institution");
$institutions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 style="text-align:center">Register New Course</h2><br>
<div class="form-container">
    <form action="" method="post">
        <div>
            <label for="name">Course Name:</label>
            <input type="text" name="course_name" required>
        </div>
        <div>
            <label for="physical_code">Course Code:</label>
            <input type="text" id="course_code" name="course_code" required>
        </div>
        
        
        
        
        
        
        
        <div>
            <label for="institution">Institution:</label>
            <select id="institution" name="institution" required>
                <option value="">Select Institution</option>
                <?php
                // Loop through each institution and create an option for the select element
                foreach ($institutions as $institution) {
                    echo "<option value='{$institution['institution_id']}'>{$institution['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <input type="submit" name="register" value="Register" style="background-color: teal;">
        </div>
    </form>
</div>

			
			
</body>
</html>

<?php
include '../connection.php';

// Fetch institutions from the database
$stmt = $pdo->query("SELECT * FROM institution");
$institutions = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt1=$pdo->query("SELECT role_id from role where role_name='student'");
$rows = $stmt->fetch(PDO::FETCH_ASSOC);
                    
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $institution_id = $_POST['institution'];
    $created_by = $_SESSION['username']; // Get username from session

    // Prepare SQL statement to insert data into the student table
    $stmt_student = $pdo->prepare("INSERT INTO course (course_name,course_code, institution_id,created_by) VALUES (:course_name, :course_code, :institution_id, :created_by)");

    

    // Bind parameters for student table
    $stmt_student->bindParam(':course_name', $course_name);
    $stmt_student->bindParam(':course_code', $course_code);
    $stmt_student->bindParam(':institution_id', $institution_id);
    $stmt_student->bindParam(':created_by', $created_by); 


    // Execute the statements
    try {
        $stmt_student->execute();
       
        echo "New course has been registered!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
