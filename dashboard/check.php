<?php  
session_start();
if (!isset($_SESSION['email'])) {
 header("location:lo.php");
}
 ?>
 <div>
<a href="logout.php">logout</a>
 </div>