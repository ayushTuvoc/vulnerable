<?php
if (!isset($_POST['submit'])) {
   header('Location: ../pages/login.php');
   exit;
}

require('../configs/db.php');

$accNo = $_POST['accountNumber'];
$password = $_POST['password'];
$hashed_password  = md5("salt". $password);

$sql = "SELECT * FROM credentials WHERE AccNo = '$accNo' AND Pass = '$hashed_password' ";

$result = mysqli_query($conn, $sql);

if ($result->num_rows == 0) {
   header('Location: ../pages/login.php?msg=Invalid Credentials');
   exit;
}else{
   $data = mysqli_fetch_assoc($result);
   session_start();
   $_SESSION['AccNo'] = $data['AccNo'];
   header('Location: ../pages/dashboard/index.php');
   exit;
}

$data = mysqli_fetch_assoc($result);
// Verify the password

if ($data) {
   $hashed_password  = md5("salt". $password);
   $Login = "SELECT * FROM credentials WHERE AccNo = '$accNo' AND Pass = '$hashed_password' ";
   $LoginCheck = mysqli_query($conn, $sql);
   if($LoginCheck){
       session_start();
       $_SESSION['AccNo'] = $data['AccNo'];
       header('Location: ../pages/dashboard/index.php');
       exit;
    } else {
       header('Location: ../pages/login.php?msg=Invalid Credentials');
       exit;
    }
} else {
    // Redirect to the login page with an error message if the account number doesn't exist
    header('Location: ../pages/login.php?msg=Account number does not exist');
    exit;
}