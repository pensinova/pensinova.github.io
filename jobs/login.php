<?php
session_start();
include 'connection.php';

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result); // fetch ONCE

        $_SESSION['username']  = $user['username'];
        $_SESSION['logged_in'] = true;
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname']  = $user['lastname'];
        $_SESSION['id']        = $user['id'];

        header("Location: dashboard.php");
        exit();

    } else {
        $error = "Invalid username or password.";
    }
}
?>


<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TSINDA - Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php include 'components/header.php'; ?>

<section class="py-5">
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">

            <div class="card border-0 shadow-lg rounded-4 p-4">

                <div class="text-center mb-4">
                    <h3 class="fw-bold">Welcome Back</h3>
                    <p class="text-muted">Login to continue your exam preparation</p>
                </div>

                <?php if (!empty($error)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label fw-medium">Username</label>
                        <input type="text" 
                               class="form-control rounded-3" 
                               name="username" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Password</label>
                        <input type="password" 
                               class="form-control rounded-3" 
                               name="password" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" 
                                class="btn btn-primary rounded-pill py-2"
                                name="login">
                            Login
                        </button>
                    </div>

                </form>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        Don’t have an account? 
                        <a href="register.php" class="text-decoration-none fw-medium">
                            Create one
                        </a>
                    </small>
                </div>

            </div>

        </div>
    </div>

</div>
</section>

<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>