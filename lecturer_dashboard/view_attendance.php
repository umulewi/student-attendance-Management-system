<?php
// session_start();
include 'conn.php';

// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit();
// }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- favicon -->
    <link rel="icon" type="img/png" href="../assets/favicon.png">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- data table cdn -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap5.css">

    <title>Attendance</title>
    <style>
    body {
        background-color: #ffffff;
    }

    .dashboard-container {
        padding: 20px;
    }

    .card {
        margin-bottom: 20px;
    }

    .dropdown-item:hover {
        background-color: #ffffcf;
    }

    a {
        color: white;
    }

    a:hover {
        color: #ffffcf;
    }

    li {
        border-bottom: 1px solid white;
    }
    </style>

</head>

<body>
    <div class="container-fluid" style="background-color: #ffffcf;">
        <div class="row shadow">
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="dashboard-container">
                    <h2> Attendance Record</h2>

                    <div class="card mt-4 shadow">
                        <div class="card-header">
                            Attendance Records <i class="fa-solid fa-check"></i>
                        </div>
                        <div class="card-body">
                            <!-- Adding alert message -->

                            <div class="d-flex justify-content-between align-items-center mb-3">


                                <!-- Display attendance records based on date -->
                                <h5>Attendance Records for
                                    <?php echo date('Y-m-d'); ?>
                                </h5>


                                <form method="post" action="View_attendance.php">
                                    <label for="attendanceDate">Select Date:</label>
                                    <input type="date" id="attendanceDate" name="attendanceDate"
                                        value="<?php echo date('Y-m-d'); ?>" required>
                                    <button type="submit" name="viewAttendance" class="btn btn-dark shadow">View
                                        Attendance</button>
                                </form>
                            </div>


                            <?php
// Check if the form is submitted to view attendance for a specific date
if (isset($_POST['viewAttendance'])) {
    $selectedDate = $_POST['attendanceDate'];

    // Fetch attendance records based on the selected date
    $stmt = $pdo->prepare("
        SELECT sa.date, sa.attendance, c.course_name, s.student_name as student_name
        FROM student_attendance sa
        INNER JOIN course c ON sa.course_id = c.course_id
        INNER JOIN student s ON sa.student_id = s.student_id
        WHERE sa.date = :selectedDate
    ");
    $stmt->bindParam(':selectedDate', $selectedDate);
    $stmt->execute();
    $attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($attendanceRecords) > 0) {
        // Display attendance records in a table format
        echo '<table id="example" class="display nowrap table table-striped" style="width:100%">';
        echo '<thead><tr><th>Date</th><th>Attendance</th><th>Course Name</th><th>Student Name</th></tr></thead>';
        echo '<tbody>';

        foreach ($attendanceRecords as $record) {
            echo '<tr>';
            echo '<td>' . $record['date'] . '</td>';
            echo '<td>' . $record['attendance'] . '</td>';
            echo '<td>' . $record['course_name'] . '</td>';
            echo '<td>' . $record['student_name'] . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p>No attendance records found for the selected date.</p>';
    }
}
?>

                        </div>
                    </div>


                </div>
            </main>
        </div>
    </div>
    <!-- bootstrap cdns -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- datatables cdns -->
    <script src="//code.jquery.com/jquery-3.7.1.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="//cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
    <script src="//cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.js"></script>
    <script src="//cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap5.js"></script>

    <!-- data table script -->
    <script>
    DataTable.defaults.responsive = true;
    new DataTable('#example');
    </script>
</body>

</html>