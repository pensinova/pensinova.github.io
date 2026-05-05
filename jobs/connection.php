<?php

// Database connection parameters
$host = 'sql110.infinityfree.com'; // Database host
$username = 'if0_39224215'; // Database username
$password = 'Pensinova123'; // Database password
$dbname = 'if0_39224215_tsinda'; // Database name

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>