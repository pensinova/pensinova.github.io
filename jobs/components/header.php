<?php
// session_start();
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm py-3">
<div class="container">

    <!-- Brand -->
    <a class="navbar-brand fw-bold fs-4" href="index.php">
        Pensinova Jobs
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler border-0" type="button" 
        data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">

            <li class="nav-item">
                <a class="nav-link text-dark fw-medium" href="#features">Features</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-dark fw-medium" href="#how">How It Works</a>
            </li>

            <?php
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

                echo '<li class="nav-item">
                        <a class="nav-link text-dark fw-medium" href="dashboard.php">Dashboard</a>
                      </li>';

                echo '<li class="nav-item">
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                            ' . htmlspecialchars($_SESSION['firstname']) . ' ' . htmlspecialchars($_SESSION['lastname']) . '
                        </span>
                      </li>';

                echo '<li class="nav-item">
                        <a class="btn btn-outline-danger rounded-pill px-3" href="logout.php">
                            Logout
                        </a>
                      </li>';

            } else {

                echo '<li class="nav-item">
                        <a class="btn btn-primary rounded-pill px-4" href="positions.php">
                            Positions
                        </a>
                      </li>';

                echo '<li class="nav-item">
                        <a class="btn btn-outline-dark rounded-pill px-4 ms-lg-2 mt-2 mt-lg-0" href="login.php">
                            Login
                        </a>
                      </li>';
            }
            ?>

        </ul>
    </div>
</div>
</nav>

<!-- Spacer to prevent content hiding under fixed navbar -->
<div style="height: 90px;"></div>