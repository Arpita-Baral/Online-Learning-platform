<?php
include '../component/connect.php'; 
setcookie('tutor_id', '', time() - 1, '/'); 
header('location:../admin/login.php'); // Redirect to login page
?>
