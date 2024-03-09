<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom styles -->
  <style>
    /* Add custom styles here */
    body {
      background-color: #f8f9fa;
    }
    .sidebar {
      position: fixed;
      top: 56px; /* Height of navbar */
      bottom: 0;
      left: 0;
      width: 250px;
      z-index: 100;
      padding: 48px 0 0;
      box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
      background-color:; /* Same color as navbar */
      transition: width 0.3s ease;
    }
    .sidebar.collapsed {
      width: 56px; /* Adjust width when collapsed */
      overflow-x: hidden;
    }
    .navbar {
      z-index: 99; /* Ensure navbar stays above sidebar */
    }
    .main-content {
      margin-left: 250px; /* Adjust as per your sidebar width */
      padding: 20px;
      transition: margin-left 0.3s ease; /* Add transition for smooth movement */
    }
    .main-content.collapsed {
      margin-left: 56px; /* Adjust margin when sidebar is collapsed */
    }
    /* Ensure dropdown menu appears over other elements */
    .dropdown-menu {
      z-index: 1000; /* Adjust as needed */
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Admin Panel</a>
    <button class="navbar-toggler" type="button" id="sidebarToggleBtn" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    
  </nav>

  <div class="sidebar" id="sidebar" style="margin-top: -3rem;">
    <div class="list-group">
      
      <div class="dropdown" style="background-color: green;">
        <a class="list-group-item list-group-item-action dropdown-toggle" href="#" role="button" id="userDropdown1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          INSTITUTION
        </a>
        <div class="dropdown-menu" aria-labelledby="userDropdown1">
          <a class="dropdown-item" href="#" onclick="showContent('View Institutions')">View Institutions</a>
          <a class="dropdown-item" href="#" onclick="showContent('Register Institution')">Register Institution</a>
        </div>
      </div>
      <div class="dropdown">
        <a class="list-group-item list-group-item-action dropdown-toggle" href="#" role="button" id="userDropdown2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          STUDENT
        </a>
        <div class="dropdown-menu" aria-labelledby="userDropdown2">
          <a class="dropdown-item" href="#" onclick="showContent('View Students')">View Students</a>
          <a class="dropdown-item" href="#" onclick="showContent('Register Student')">Register Student</a>
        </div>
      </div>
      <div class="dropdown">
        <a class="list-group-item list-group-item-action dropdown-toggle" href="#" role="button" id="userDropdown3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          LECTURER
        </a>
        <div class="dropdown-menu" aria-labelledby="userDropdown3">
          <a class="dropdown-item" href="#" onclick="showContent('View Lecturers')">View Lecturers</a>
          <a class="dropdown-item" href="#" onclick="showContent('Register Lecturer')">Register Lecturer</a>
        </div>
      </div>
      <div class="dropdown">
        <a class="list-group-item list-group-item-action dropdown-toggle" href="#" role="button" id="userDropdown4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          ATTENDANCE
        </a>
        <div class="dropdown-menu" aria-labelledby="userDropdown4">
          <a class="dropdown-item" href="#" onclick="showContent('View Attendances')">View Attendances</a>
        </div>
      </div>
    </div>
  </div>

  <div class="main-content" id="mainContent">
    <!-- Main content area -->
    
    <div id="content">
      <p>This is the main content area. You can display various information and controls here.</p>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script>
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
