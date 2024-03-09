<?php  
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
    exit();
}
?>

<?php

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

<h2 style="margin-top:2rem;text-align:center">All Lectures</h2>
<table>
    <thead>
        <tr>
            <th>lecturer Name</th>
            <th>Lecturer email</th>
            <th>Lecturer Phone</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT lecturer.* FROM lecturer, institution, users WHERE lecturer.institution_id = institution.institution_id AND lecturer.users_id = users.users_id AND institution.institution_id = ( SELECT institution_id FROM lecturer, users WHERE lecturer.users_id = users.users_id AND users.username = :username );ORDER BY lecturer.lecturer_name;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) {
            echo "<tr>";
            echo "<td>" . $result['lecturer_name'] . "</td>";
            echo "<td>" . $result['lecturer_email'] . "</td>";
            echo "<td>" . $result['lecturer_phone'] . "</td>";
           

           
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
