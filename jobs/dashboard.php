<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TSINDA - Admin Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
      transition: background .3s, color .3s;
  }
  #sidebar {
      width: 260px;
      min-height: 100vh;
      transition: all .3s;
  }
  .sidebar-text {
      transition: opacity .3s;
  }
  .collapsed #sidebar {
      width: 70px;
  }
  .collapsed .sidebar-text {
      opacity: 0;
      display: none !important;
  }
</style>
</head>

<body class="bg-dark text-light">

<div class="d-flex" id="main-wrapper">

    <!-- Sidebar -->
    <div id="sidebar" class="bg-black border-end border-secondary p-3 d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="fw-bold fs-5 sidebar-text">TSINDA Admin</span>
            <button class="btn btn-sm btn-outline-light" onclick="toggleSidebar()">☰</button>
        </div>

        <ul class="nav nav-pills flex-column gap-2 mb-auto">

            <li class="nav-item">
                <a href="#" class="nav-link active bg-primary rounded-3 d-flex align-items-center gap-2">
                    <span>📊</span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link text-light rounded-3 d-flex align-items-center gap-2">
                    <span>👥</span>
                    <span class="sidebar-text">Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link text-light rounded-3 d-flex align-items-center gap-2">
                    <span>📝</span>
                    <span class="sidebar-text">Exams</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link text-light rounded-3 d-flex align-items-center gap-2">
                    <span>💳</span>
                    <span class="sidebar-text">Subscriptions</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="logout.php" class="nav-link text-danger rounded-3 d-flex align-items-center gap-2">
                    <span>🚪</span>
                    <span class="sidebar-text">Logout</span>
                </a>
            </li>

        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">

        <!-- Topbar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Admin Dashboard</h4>
                <small class="text-secondary">
                    Welcome, <?php echo htmlspecialchars($_SESSION['firstname']); ?>
                </small>
            </div>

         
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">

            <div class="col-md-3">
                <div class="card bg-secondary border-0 rounded-4 p-4">
                    <small>Total Users</small>
                    <h3 class="fw-bold">1,254</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-secondary border-0 rounded-4 p-4">
                    <small>Active Subscriptions</small>
                    <h3 class="fw-bold">842</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-secondary border-0 rounded-4 p-4">
                    <small>Exams Available</small>
                    <h3 class="fw-bold">38</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-secondary border-0 rounded-4 p-4">
                    <small>Monthly Revenue</small>
                    <h3 class="fw-bold">$4,920</h3>
                </div>
            </div>

        </div>

        <!-- Subscription Table -->
        <div class="card bg-secondary border-0 rounded-4 p-4">
            <h5 class="fw-semibold mb-4">Recent Subscriptions</h5>

            <div class="table-responsive">
                <table class="table table-dark table-borderless align-middle">

                    <thead class="border-bottom border-secondary">
                        <tr>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Expiry</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>Premium</td>
                            <td>
                                <span class="badge bg-success-subtle text-success rounded-pill">
                                    Active
                                </span>
                            </td>
                            <td>2026-03-01</td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>Basic</td>
                            <td>
                                <span class="badge bg-warning-subtle text-warning rounded-pill">
                                    Pending
                                </span>
                            </td>
                            <td>2026-02-28</td>
                        </tr>
                        <tr>
                            <td>David Kim</td>
                            <td>Premium</td>
                            <td>
                                <span class="badge bg-danger-subtle text-danger rounded-pill">
                                    Expired
                                </span>
                            </td>
                            <td>2026-01-15</td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>

<script>
const wrapper = document.getElementById('main-wrapper');
const toggleBtn = document.getElementById('themeToggle');

function toggleSidebar() {
    wrapper.classList.toggle('collapsed');
}


</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>