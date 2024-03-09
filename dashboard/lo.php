<form method="post" action="">
            <div class="mb-3">
              <label class="form-label">Email </label>
              <input type="email" name="email" class="form-control shadow-none" re4>
            </div>
            <div class="mb-4">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control shadow-none" required>
            </div>
            <input type="submit" name="user_login" value="Login" style="background-color:teal" class="btn">

            
            </form>

            <?php
include '../connection.php';

if (isset($_POST['user_login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $statement = $pdo->prepare("SELECT * FROM student WHERE email=:email AND password=:password");
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', $password);
    $statement->execute();
    $rows = $statement->fetch(PDO::FETCH_ASSOC);
    if ($rows) {
      if ($rows['email'] == $email && $rows['password'] == $password) {
          session_start();
          $_SESSION['email'] = $email;
          //header("location:rooms.php");
          echo "<script>window.location.replace('check.php')</script>";
      } else {
          echo "<script>";
          echo 'alert("Incorrect username and password")';
          echo "</script>";
      }
  } else {
      echo "<script>";
      echo 'alert("Incorrect username and password")';
      echo "</script>";
  }
}
?>
