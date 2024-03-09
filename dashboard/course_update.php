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
    <title>Update Student</title>
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


$course_id = $_GET['course_id'];
$stmt = $pdo->prepare("SELECT * FROM course WHERE course_id = :course_id");
$stmt->execute(['course_id' => $course_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<?php 
$stmt = $pdo->query("SELECT * FROM institution");
$institutions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 style="text-align:center">Update Course</h2><br>
<div class="form-container">
    <form action="" method="post">
        <div>
            <label for="name">course Name:</label>
            <input type="text" name="course_name" value="<?php echo $row['course_name']; ?>" required>
        </div>
        <div>
            <label for="name">Course Code:</label>
            <input type="text" name="course_code" value="<?php echo $row['course_code']; ?>" required>
        </div>
        <div>
            <label for="institution">Institution:</label>
            <select id="institution" name="institution" required>
                <option value="">Select Institution</option>
                <?php
                
                foreach ($institutions as $institution) {
                    $selected = ($institution['institution_id'] == $row['institution_id']) ? "selected" : "";
                    echo "<option value='{$institution['institution_id']}' $selected>{$institution['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <input type="submit" name="update" value="Update" style="background-color: teal;">
        </div>
    </form>
</div>

</body>
</html>

<?php
include '../connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $institution_id = $_POST['institution'];
    $updated_by = $_SESSION['username']; 

    $stmt = $pdo->prepare("UPDATE course SET course_name= :course_name, course_code = :course_code,updated_by= :updated_by, institution_id = :institution_id WHERE course_id = :course_id");

    // Bind parameters
    $stmt->bindParam(':course_name', $course_name);
    $stmt->bindParam(':course_code', $course_code);
    $stmt->bindParam(':institution_id', $institution_id);
    $stmt->bindParam(':updated_by',$updated_by);
    $stmt->bindParam(':course_id', $course_id);

    // Execute the statement
    try {
        $stmt->execute();
        echo "course details updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
