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

<h2 style="text-align:center">Register New Lecturer</h2><br>
<div class="form-container">
    <form action="" method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" name="lecturer_name" required>
        </div>
        <div>
            <label for="physical_code">Email:</label>
            <input type="text" id="email" name="lecturer_email" required>
        </div>
        
        <div>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="lecturer_phone" required>
        </div>
        <div>
            <label for="email">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="email">Password:</label>
            <input type="password" id="password" name="password" required>
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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $lecturer_name = $_POST['lecturer_name'];
    $lecturer_email = $_POST['lecturer_email'];
    $lecturer_phone = $_POST['lecturer_phone'];
    $institution_id = $_POST['institution'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $created_by = $_SESSION['username'];
    $role_id = $_GET['role_id'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into users table
    $stmt_user = $pdo->prepare("INSERT INTO users (username, password, role_id) VALUES (:username, :password, :role_id)");

    $stmt_user->bindParam(':username', $username);
    $stmt_user->bindParam(':password', $hashed_password); // Store the hashed password
    $stmt_user->bindParam(':role_id', $role_id);
    $stmt_user->execute();

    $users_id = $pdo->lastInsertId();

    // Prepare SQL statement to insert data into the student table
    $stmt = $pdo->prepare("INSERT INTO lecturer (lecturer_name, lecturer_email, lecturer_phone, institution_id,users_id,role_id,created_by) VALUES (:lecturer_name, :lecturer_email, :lecturer_phone, :institution_id, :users_id, :role_id, :created_by)");

    // Bind parameters
    $stmt->bindParam(':lecturer_name', $lecturer_name);
    $stmt->bindParam(':lecturer_phone', $lecturer_phone);
    $stmt->bindParam(':lecturer_email', $lecturer_email);
    $stmt->bindParam(':institution_id', $institution_id);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':created_by', $created_by);
    $stmt->bindParam(':role_id', $role_id);

    // Execute the statement
    try {
        $stmt->execute();
        echo "New student has been registered!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
