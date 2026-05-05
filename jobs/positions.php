<?php
session_start();
include 'connection.php';


$message = "";
$type = "";

if (isset($_POST['register'])) {

     $firstname = trim($_POST['firstname']);
     $lastname = trim($_POST['lastname']);
     $phone = trim($_POST['phone']);
     $email = trim($_POST['email']);
     $passcode = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 8);
     

     $insert = mysqli_query($conn, "INSERT INTO subscriptions (firstname, lastname, phone, email, passcode) VALUES ('$firstname', '$lastname', '$phone', '$email', '$passcode')");

     if ($insert) {
          $message = "Registration successful! Now pay 5000 rwf on 1234567 then <a href='contact.php'>contact</a> us for your access code.";
          $type = "success";
     } else {
          $message = "An error occurred. Please try again.";
          $type = "danger";
     }

     
}
?>

<?php
$data = file_get_contents('data/exams.json');
$exams = json_decode($data, true);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pensinova Jobs - Positions</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<?php include 'components/header.php'; ?>

<section class="d-flex align-items-center justify-content-center ">
<div class="container ">

     <h3 class="text-center">Positions</h3>
     <p class="text-center lead">Select a position to view available tests.</p>
     <div class="row justify-content-center g-3 mt-4">

     <?php foreach($exams as $exam): ?>

          <a href="exams.php?position=<?php echo urlencode($exam['position']); ?>" class="col-6 col-md-2 text-decoration-none">
               <div class="card shadow border-0 rounded-4 py-5">
                    <div class="card-body text-center">

                        <p class="fw-bold"><?php echo ucfirst(htmlspecialchars($exam['position'])); ?></p>
                   </div>
               </div>
          </a>
<?php endforeach; ?>


     </div>
</div>
</section>

<!-- footer -->

<?php include 'components/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>