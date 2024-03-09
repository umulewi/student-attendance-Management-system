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


$student_id = $_GET['student_id'];
$stmt = $pdo->prepare("SELECT * FROM student WHERE student_id = :student_id");
$stmt->execute(['student_id' => $student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $pdo->query("SELECT * FROM institution");
$institutions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 style="text-align:center">Update Student</h2><br>
<div class="form-container">
    <form action="" method="post">
        <div>
            <label for="name">Reg Number:</label>
            <input type="text" name="reg_no" value="<?php echo $student['reg_no']; ?>" required>
        </div>
        <div>
            <label for="physical_code">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo $student['email']; ?>" required>
        </div>
        
        <div>
            <label for="phone">Studen Name:</label>
            <input type="text" id="student_name" name="student_name" value="<?php echo $student['student_name']; ?>" required>
        </div>
        <div>
            <label for="institution">Institution:</label>
            <select id="institution" name="institution" required>
                <option value="">Select Institution</option>
                <?php
                
                foreach ($institutions as $institution) {
                    $selected = ($institution['institution_id'] == $student['institution_id']) ? "selected" : "";
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

    $reg_no = $_POST['reg_no'];
    $email = $_POST['email'];

    $student_name = $_POST['student_name'];
    $institution_id = $_POST['institution'];
    $updated_by = $_SESSION['username']; 
    $student_id = $_GET['student_id'];
    

   
    $stmt = $pdo->prepare("UPDATE student SET reg_no = :reg_no, email = :email, student_name = :student_name,updated_by= :updated_by, institution_id = :institution_id WHERE student_id = :student_id");

    // Bind parameters
    $stmt->bindParam(':reg_no', $reg_no);
    $stmt->bindParam(':email', $email);
 
    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':institution_id', $institution_id);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':updated_by',$updated_by);

    // Execute the statement
    try {
        $stmt->execute();
        echo "Student details updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
