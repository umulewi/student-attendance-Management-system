<?php  
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
    exit();
}
include'../connection.php';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">
    <title>Attandance Management System</title>
    <style>
        /* Additional CSS for dropdown icon */
        .dropdown-icon {
            margin-left: auto;
            transform: rotate(0deg);
            transition: transform 0.3s ease;
        }

        .dropdown-icon.open {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            display: none;
        }

        .dropdown-menu.active {
            display: block;
        }

        /* Hide the dropdown icon when the menu is open */
        .dropdown-menu.active + .dropdown-icon {
            display: none;
        }

        /* Add margin to the subsequent nav elements */
        .subsequent-nav.pushed-down {
            margin-top: 50px; /* Adjust this value as needed */
        }
    </style>
</head>
<body>


    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="index.php" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">AMS</span>
        </a>
        <ul class="side-menu top">
            
            
            <li>
                <a href="#" class="dropdown-toggle" data-nav="top">
                    <i class='bx bxs-doughnut-chart' ></i>
                    <span class="text">Student</span>
                    <i class='bx bx-chevron-down dropdown-icon'></i>
                </a>
                <!-- Dropdown Menu -->
                
                <ul class="dropdown-menu">
                    <li><a href="ViewStudent.php">View Student</a></li>
  
                </ul>
            </li>
            <li>
                <a href="#" class="dropdown-toggle" data-nav="top">
                    <i class='bx bxs-message-dots' ></i>
                    <span class="text">Lecturer</span>
                    <i class='bx bx-chevron-down dropdown-icon'></i>
                </a>
                <!-- Dropdown Menu -->
                
                <ul class="dropdown-menu">
                    <li><a href="ViewLecturer.php">View Lecturer</a></li>
                    
                   
                </ul>
            </li>
            <li>
                <a href="#" class="dropdown-toggle" data-nav="top">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Courses</span>
                    <i class='bx bx-chevron-down dropdown-icon'></i>
                </a>
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                    <li><a href="ViewCourses.php">View Courses</a></li>
    
                    
                </ul>
            </li>
            <li>
                <a href="#" class="dropdown-toggle" data-nav="top">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Attendance</span>
                    <i class='bx bx-chevron-down dropdown-icon'></i>
                </a>
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                    <li><a href="ViewAttendance.php">View attendance</a></li>
                    
                </ul>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="edit.php">
                    <i class='bx bxs-cog' ></i>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="logout.php" class="logout">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav class="subsequent-nav">
            <i class='bx bx-menu' ></i>
            
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            
        </nav>
        <!-- NAVBAR -->
        


            <!-- display all content in-->


            <main>
			

			<ul class="box-info">
				
                <li>
					<i class='bx bxs-calendar-check' ></i>
					<?php
                    include'../connection.php';
                    $sql = "SELECT COUNT(course_id) AS total FROM course";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
					<span class="text">
						<h3><?php echo $result['total']?></h3>
						<p>Courses</p>
					</span>
				</li>
                
				<li>
					<i class='bx bxs-group' ></i>
					<?php
                    include'../connection.php';
                    $sql = "SELECT COUNT(student_id) AS total FROM student";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
					<span class="text">
						<h3><?php echo $result['total']?></h3>
						<p>Students</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<?php
                    include'../connection.php';
                    $sql = "SELECT COUNT(lecturer_id) AS total FROM lecturer";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
					<span class="text">
						<h3><?php echo $result['total']?></h3>
						<p>Lecturers</p>
					</span>
				</li>
			</ul>


			
		</main>

		
    <!-- CONTENT -->
    

    <script src="script.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const dropdownToggles = document.querySelectorAll("#sidebar .dropdown-toggle");

    dropdownToggles.forEach(function(dropdownToggle) {
        dropdownToggle.addEventListener("click", function(event) {
            event.preventDefault();

            const clickedDropdownMenu = this.nextElementSibling;

            // Close all active dropdowns except the one being clicked
            const activeDropdownMenus = document.querySelectorAll("#sidebar .dropdown-menu.active");
            activeDropdownMenus.forEach(function(menu) {
                if (menu !== clickedDropdownMenu) {
                    menu.classList.remove("active");
                    menu.previousElementSibling.querySelector(".dropdown-icon").classList.remove("open");
                }
            });

            // Toggle active class for the clicked dropdown menu
            clickedDropdownMenu.classList.toggle("active");
            this.querySelector(".dropdown-icon").classList.toggle("open");

            // Hide other subsequent nav elements
            const otherNavs = document.querySelectorAll("#sidebar .subsequent-nav:not(." + this.getAttribute("data-nav") + ")");
            otherNavs.forEach(function(nav) {
                nav.style.display = "none";
            });

            // Stop the click event from propagating to the subsequent nav elements
            event.stopPropagation();
        });

        // Prevent the dropdown toggle from toggling the dropdown menu
        dropdownToggle.addEventListener("mouseenter", function(event) {
            const clickedDropdownMenu = this.nextElementSibling;

            // Hide other dropdown menus
            const otherDropdownMenus = document.querySelectorAll("#sidebar .dropdown-menu");
            otherDropdownMenus.forEach(function(menu) {
                if (menu !== clickedDropdownMenu) {
                    menu.classList.remove("active");
                    menu.previousElementSibling.querySelector(".dropdown-icon").classList.remove("open");
                }
            });

            // Hide other subsequent nav elements
            const otherNavs = document.querySelectorAll("#sidebar .subsequent-nav:not(." + this.getAttribute("data-nav") + ")");
            otherNavs.forEach(function(nav) {
                nav.style.display = "none";
            });
        });
    });

    // Close dropdown menu when clicking outside of it
    document.addEventListener("click", function(event) {
        const dropdownMenus = document.querySelectorAll("#sidebar .dropdown-menu");
        dropdownMenus.forEach(function(menu) {
            menu.classList.remove("active");
            menu.previousElementSibling.querySelector(".dropdown-icon").classList.remove("open");
        });

        const subsequentNavs = document.querySelectorAll("#sidebar .subsequent-nav");
        subsequentNavs.forEach(function(nav) {
            nav.style.display = "none";
        });
    });
});

function showContent(content) {
      document.getElementById("content").innerHTML = content;
    }

    document.getElementById("sidebarToggleBtn").addEventListener("click", function() {
      document.getElementById("sidebar").classList.toggle("collapsed");
      document.getElementById("mainContent").classList.toggle("collapsed");
    });

    </script>
</body>
</html>