<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
    exit();
}
include '../connection.php';
include 'dashboard.php';
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: teal;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
        }
        .btn.delete {
            background-color: crimson;
        }
        .btn.update {
            background-color: #b0b435;
        }
    </style>
</head>
<body>

<h2 style="margin-top:2rem;text-align:center">All Students</h2>
<table>
    <thead>
        <tr>
            <th>Student Name</th>
            <th>REG Numbers</th>
            
            
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT student.* FROM student, institution, users WHERE student.institution_id = institution.institution_id AND student.users_id = users.users_id AND institution.institution_id = ( SELECT institution_id FROM student, users WHERE student.users_id = users.users_id AND users.username = :username );ORDER BY student.student_name;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) {
            echo "<tr>";
            echo "<td>" . $result['student_name'] . "</td>";
            echo "<td>" . $result['reg_no'] . "</td>";
           
           

           
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
