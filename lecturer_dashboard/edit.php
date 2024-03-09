<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
    exit();
}
$usernamee = $_SESSION['username'];
include'dashboard.php';
?>
<?php
include '../connection.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
    // Retrieve form data
    $lecturer_name = $_POST['lecturer_name'];
    $lecturer_email = $_POST['lecturer_email'];
    $lecturer_phone = $_POST['lecturer_phone'];
    $username=$_POST['username'];
    $pass=$_POST['password'];
    $password=password_hash($pass , PASSWORD_DEFAULT);

    $updated_by = $_SESSION['username']; 

    // Retrieve student ID from URL parameter
    $lecturer_id = $_POST['lecturer_id'];

    // Prepare SQL statement to update data in the student table
    $stmt = $pdo->prepare("UPDATE lecturer SET lecturer_name = :lecturer_name, lecturer_email = :lecturer_email, lecturer_phone = :lecturer_phone,updated_by =:updated_by  WHERE lecturer_id = :lecturer_id");
    $stmt->bindParam(':lecturer_name', $lecturer_name);
    $stmt->bindParam(':lecturer_email', $lecturer_email);
    $stmt->bindParam(':lecturer_phone', $lecturer_phone);
    $stmt->bindParam(':lecturer_id', $lecturer_id);
    $stmt->bindParam(':updated_by', $updated_by);
    $stmt->execute();


    $stmt=$pdo->prepare("UPDATE users SET username= :username, password= :password WHERE username=:username");


    // Bind parameters
    $stmt->bindParam(':username', $usernamee);
    $stmt->bindParam(':password', $password);

    
    echo" well updated";
  

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
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

// Fetch student details based on ID

$stmt = $pdo->prepare("SELECT * FROM users  join lecturer on lecturer.users_id=users.users_id join institution on lecturer.institution_id = institution.institution_id WHERE users.username = :username");
$stmt->bindParam(':username',$usernamee);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);



// Fetch institutions from the database

?>
<h2 style="text-align:center">Lecturer Update</h2><br>
<div class="form-container">
    <form action="" method="post">
    <div>
           
            <input type="text" name="lecturer_id" value="<?php echo $row['lecturer_id']; ?>" required  style='display:none'>
        </div>
        <div>
            <label for="name">Lecturer_name:</label>
            <input type="text" name="lecturer_name" value="<?php echo $row['lecturer_name']; ?>" required>
        </div>
        <div>
            <label for="physical_code">Phone:</label>
            <input type="text" id="lecturer_phone" name="lecturer_phone" value="<?php echo $row['lecturer_phone']; ?>" required>
        </div>
        <div>
            <label for="physical_code">Email:</label>
            <input type="text" id="lecturer_email" name="lecturer_email" value="<?php echo $row['lecturer_email']; ?>" required>
        </div>
        <div>
            <label for="physical_code">Username:</label>
            <input type="text" id="" name="username" value="<?php echo $row['username']; ?>" required>
        </div>
        <div>
            <label for="physical_code">Password:</label>
            <input type="password" id="lecturer_email" name="password" value="<?php echo $row['password']; ?>" required>
        </div>

        
        <div>
            <input type="submit" name="update" value="Update" style="background-color: teal;">
        </div>
    </form>
</div>

</body>
</html>




