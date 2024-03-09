
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
$id = $_GET['institution_id'];
include'../connection.php';
$stmt = $pdo->prepare("SELECT * FROM institution WHERE institution_id = :institution_id");
$stmt->bindParam(':institution_id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h2 style="text-align:center">Instititution Update</h2><br>
<div class="form-container">
    <form action="" method="post">
        <div>
            <label for="name">Institution Name:</label>
            <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
        </div>
        <div>
            <label for="physical_code">Physical Code:</label>
            <input type="text" id="physical_code" name="physical_code" value="<?php echo $row['physical_code']; ?>" required>
        </div>
        <div>
            <label for="physical_code">Email:</label>
            <input type="text" id="lecturer_email" name="email" value="<?php echo $row['email']; ?>" required>
        </div>
        <div>
            <label for="physical_code">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required>
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

if (isset($_POST['update'])) {
    $institution_id = $_GET['institution_id'];
    $name=$_POST['name'];
    $physical_code = $_POST['physical_code'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $updated_by = $_SESSION['username']; 
    $updated_on = date('Y-m-d H:i:s'); 

    try {
        // Fetch existing values
        $stmt_existing = $pdo->prepare("SELECT created_by FROM institution WHERE institution_id = :institution_id");
        $stmt_existing->bindParam(':institution_id', $institution_id);
        $stmt_existing->execute();
        $row_existing = $stmt_existing->fetch(PDO::FETCH_ASSOC);
        $created_by = $row_existing['created_by']; // Use existing created_by value

        // Prepare the SQL statement
        $sql = "UPDATE institution 
                SET physical_code = :physical_code, 
                    email = :email, 
                    name=   :name,
                    phone = :phone, 
                    created_by = :created_by, 
                    updated_by = :updated_by, 
                    updated_on = :updated_on 
                WHERE institution_id = :institution_id";

        // Prepare statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':physical_code', $physical_code);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':updated_by', $updated_by);
        $stmt->bindParam(':updated_on', $updated_on);
        $stmt->bindParam(':institution_id', $institution_id);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>window.location.href = 'view_institution.php';</script>";

            exit();
        } else {
            echo "<script>alert('Error updating record');</script>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

