<!-- Sidebar -->
<div class="d-flex flex-column p-4 bg-white border-end" 
     style="width: 280px; height: 100vh; position: fixed;">

    <!-- Brand -->
    <a href="dashboard.php" 
       class="d-flex align-items-center mb-4 text-decoration-none">
        <span class="fs-5 fw-bold text-dark">
            Pensinova Jobs
        </span>
    </a>

    <!-- Navigation -->
    <ul class="nav nav-pills flex-column gap-2 mb-auto">

        <li class="nav-item">
            <a href="dashboard.php" 
               class="nav-link rounded-3 px-3 py-2 fw-medium text-dark 
               <?php echo basename($_SERVER['PHP_SELF'])=='dashboard.php' ? 'active bg-primary text-white' : ''; ?>">
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="subscriptions.php" 
               class="nav-link rounded-3 px-3 py-2 fw-medium text-dark
               <?php echo basename($_SERVER['PHP_SELF'])=='subscriptions.php' ? 'active bg-primary text-white' : ''; ?>">
                Subscriptions
            </a>
        </li>

        <li class="nav-item">
            <a href="settings.php" 
               class="nav-link rounded-3 px-3 py-2 fw-medium text-dark
               <?php echo basename($_SERVER['PHP_SELF'])=='settings.php' ? 'active bg-primary text-white' : ''; ?>">
                Settings
            </a>
        </li>

    </ul>

    <!-- User Section -->
    <div class="mt-4 pt-4 border-top">

        <div class="dropdown">

            <a href="#" 
               class="d-flex align-items-center text-decoration-none dropdown-toggle"
               id="dropdownUser" 
               data-bs-toggle="dropdown" 
               aria-expanded="false">

                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2"
                     style="width:40px;height:40px;">
                    <?php echo strtoupper(substr($_SESSION['firstname'],0,1)); ?>
                </div>

                <div>
                    <div class="fw-semibold text-dark small">
                        <?php echo htmlspecialchars($_SESSION['firstname']) . ' ' . htmlspecialchars($_SESSION['lastname']); ?>
                    </div>
                    <div class="text-muted small">
                        Account
                    </div>
                </div>

            </a>

            <ul class="dropdown-menu shadow border-0 mt-2">
                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="logout.php">
                        Logout
                    </a>
                </li>
            </ul>

        </div>

    </div>

</div>