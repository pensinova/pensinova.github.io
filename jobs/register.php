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

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pensinova Jobs - Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<?php include 'components/header.php'; ?>

<section class="d-flex align-items-center justify-content-center ">
<div class="container">
     <div class="row justify-content-center">
          <div class="col-md-6 col-lg-4">

               <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">

                         <h4 class="text-center fw-bold mb-4">Create Account</h4>

                         <?php if($message): ?>
                         <div class="alert alert-<?php echo $type; ?>">
                              <small><?php echo $message; ?></small>
                         </div>
                         <?php endif; ?>

                         <form method="POST">

                              <div class="mb-3">
                                   <input type="text" class="form-control" name="firstname" placeholder="First Name" required>
                              </div>

                              <div class="mb-3">
                                   <input type="text" class="form-control" name="lastname" placeholder="Last Name" required>
                              </div>

                            
                              <div class="mb-3">
                                   <input type="phone" class="form-control" name="phone" placeholder="Phone" required>
                              </div>

                              <div class="mb-3">
                                   <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                              </div>

                              <button type="submit" name="register" class="btn btn-primary w-100 rounded-pill">
                                   Register
                              </button>

                              <div class="text-center mt-3">
                                   <small>
                                        Already have access?
                                        <a style="cursor: pointer" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Enter code</a>
                                        
                                   </small>
                              </div>

                         </form>


                         <!-- Modal -->
                         <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                         <div class="modal-dialog">
                         <div class="modal-content">
                              <form action="" method="post">
                              <div class="modal-header">
                              <h1 class="modal-title fs-5" id="staticBackdropLabel">Access code</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                              
                              <p class="text-center">
                                  <small class="text-muted"> If you have successfully paid 5000 rwf on MOMO Code 1234567,  <a href="contact.php">contact</a> the administrator to obtain an access code for registration.</small>
                                   </p>

                                   
                                   <div class="mb-3 mt-4">
                                        <input type="text" class="form-control shadow border-2" name="access_code" placeholder="Enter Your Access Code" required>     
                                  
                              </div>
                              <div class="modal-footer">
                              <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-primary " name="access">Start</button>
                               </form>
                              </div>
                         </div>
                         </div>
                         </div>
                    </div>
               </div>

          </div>
     </div>
</div>
</section>

<!-- footer -->

<?php include 'components/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>