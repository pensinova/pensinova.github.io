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

$position = isset($_GET['position']) ? $_GET['position'] : null;

$ex = null;
if($position) {
    foreach($exams as $e) {
        if($e['position'] === $position) {
            $ex = $e;
            break;
        }
    }
}
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

     <h3 class="text-center"><?php echo ucfirst(htmlspecialchars($_GET['position'])); ?> - Tests</h3>
     <div class="row justify-content-center g-3 mt-4">

     <?php foreach($ex['exams'] as $i=>$e): ?>

          <a href="exam.php?exam=<?php echo urlencode($i); ?>&question=0&position=<?php echo urlencode($position); ?>" class="col-6 col-md-2 text-decoration-none">
               <div class="card shadow border-0 rounded-4 py-3">
                    <div class="card-body text-center">

                        <p class="fw-bold"><?php echo "Test " . ($i+1); ?></p>
                        <small class="text-muted">Marks: <?php echo "0%"; ?></small>
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