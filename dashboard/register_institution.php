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
        .form-container input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensure padding and border are included in width */
        }
        .form-container input[type="tel"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensure padding and border are included in width */
        }

        /* Submit button */
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
    <h2 style="text-align:center;margin-top:2rem">Register New Institution</h2><br>
<div class="form-container">
    
        <form action="" method="post">
            <div>
                <label for="name">NAME:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="physical_code">PHYSICAL CODE:</label>
                <input type="text" id="physical_code" name="physical_code" required>
            </div>
            <div>
                <label for="email">EMAIL:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="phone">PHONE:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            
            <div>
                <input type="submit" name="register" value="Register" stayle="background-color:red">
            </div>
        </form>
    </div>
			
			
</body>
</html>

<?php
// Start session


// Include database connection
include '../connection.php';

if (isset($_POST["register"])) {
    $name = $_POST["name"];
    $physical_code = $_POST["physical_code"];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Assuming you have stored username in the session
    $created_by = $_SESSION['username'];

    // Hashing the password using MD5
    $password = md5($_POST['password']);

    try {
        // Prepare the SQL statement with placeholders
        $sql = "INSERT INTO institution (name, physical_code, email, phone, created_by, password) VALUES (:name, :physical_code, :email, :phone, :created_by, :password)";
        
        // Prepare statement
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':physical_code', $physical_code);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':created_by', $created_by); // Bind username from session
        $stmt->bindParam(':password', $password); // Bind hashed password
        
        // Execute the statement
        if ($stmt->execute()) {
          echo "<script>";
          echo 'alert("New Institution has been added")';
          echo "</script>";
        } else {
            echo "Error: Unable to execute statement";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>