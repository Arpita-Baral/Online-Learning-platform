<?php 
    include 'component/connect.php';

    if(isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }
    if(isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }
    if(isset($_POST['submit'])){
       
        $email=$_POST['email'];
        $email=filter_var($email,FILTER_SANITIZE_EMAIL);
        $pass = $_POST['pass']; 
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);// No hashing here
        $select_user=$conn->prepare("SELECT * FROM `user` WHERE email=? AND password=? LIMIT 1");
        $select_user->execute([$email, $pass]);
        $row=$select_user->fetch(PDO::FETCH_ASSOC);
        if($select_user->rowCount()>0){
            setcookie("user_id", $row["id"], time()+ 60*60*24*30,"/");
            header("location:index.php");
        }else{
            $message[]='Incorrect Email Or Password';
        }
}
   
?>
<style>
     <?php  include 'style/style2.css';  ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<?php include 'component/user_header.php';?>
<div class="banner">
    <div class="detail">
        <div class="title">
            <a href="index.php">Home</a><span><i class="bx bx-chevron-right"></i>About</span>
        </div>
        <h1>Register Now</h1>
        <div class="flex-btn">
            <a href="login.php" class="btn">Login to Start</a>
            <a href="contact.php" class="btn">Contact us</a>
        </div>
    </div>
    <img src="image/about.png" alt="">
</div>
<!-- register section -->
 <section class="form-container">
    <div class="heading">
        <span>Already Joined</span>
        <h1>Welcome Back</h1>
    </div>
<form class="login" method="post" enctype="multipart/form-data">
        <p>Your Email<span>*</span></p>
        <input type="email" name="email" placeholder="Enter Your Email" maxlength="50" required class="box">
        <p>Your Password<span>*</span></p>
        <input type="password" name="pass" placeholder="Enter Your Password" maxlength="20" required class="box">

     <p class="link">Do not have an account?<a href="register.php">Register now</a></p><a href="register.php">forgot password</a></p>
    <input type="submit" name="submit" class="btn" value="Log in now">            
</form>

 </section>
 
<?php include 'component/footer.php';
?>
<script src="js/user_script.js"></script>
</body>
</html>