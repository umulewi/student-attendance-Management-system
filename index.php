<?php
include 'connection.php';

if (isset($_POST['user_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user record from the database
    $statement = $pdo->prepare("SELECT users.*, role.role_name, users.password AS hashed_password FROM users INNER JOIN role ON users.role_id = role.role_id WHERE username=:username");
    $statement->bindParam(':username', $username);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists and if the entered password matches the hashed password
    if ($user && password_verify($password, $user['hashed_password'])) {
        session_start();
        $_SESSION['username'] = $username;
        
        // Redirect based on role
        $role_name = $user['role_name'];
        switch ($role_name) {
            case 'admin':
                header("Location: dashboard/admin.php");
                break;
            case 'student':
                header("Location: student_dashboard/index.php");
                break;
            case 'lecturer':
                header("Location: lecturer_dashboard/index.php");
                break;
            default:
                // Default redirect if role is not recognized
                header("Location: default_dashboard.php");
                break;
        }
        exit(); // Stop further execution
    } else {
        echo "<script>alert('Incorrect username and password');</script>";
    }
}
?>




<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .login-link {
      position: absolute;
      top: 10px; 
      right: 0px; 
      color: white;
      cursor: pointer;  
    }
    
  </style>
</head>
<body style="background-color: teal;">
<div class="container">
  <button href="#" class="login-link btn" data-bs-toggle="modal" data-bs-target="#loginModal" style="background-color: red;">LOGIN</button>
  
</div>

  
  <div class="container" style="margin-top: 15rem;">
        <div class="row">
          <div class="col-lg-10">
            <h2 data-aos="fade-up" data-aos-delay="100">Welcome to Attendance Management System </h2>
            <p data-aos="fade-up" data-aos-delay="200">AMS tracks and manages students attendances digitally for efficient monitoring and reporting.</p>
          </div>
          
        </div>
      </div>

  <!-- Modal HTML -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Add your login form here -->
          <form method="post" action="">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control shadow-none" re4>
            </div>
            <div class="mb-4">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control shadow-none" required>
            </div>
            <input type="submit" name="user_login" value="Login" style="background-color:teal" class="btn">

            
            </form>
        </div>
      </div>
    </div>
  </div>

  
  




</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
