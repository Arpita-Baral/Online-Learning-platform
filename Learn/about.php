<?php 
    include 'component/connect.php';

    if(isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
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
    <title>Home Page</title>
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
        <h1>About Us</h1>
        <div class="flex-btn">
            <a href="login.php" class="btn">Login to Start</a>
            <a href="contact.php" class="btn">Contact us</a>
        </div>
    </div>
    <img src="image/about.png" alt="">
</div>
<div class="about-box">
    <div class="main-heading">
        <h1>Know More About Our Platform</h1>
    </div>
    
    <div class="inner-box-container">
        <div class="inner-box">
            <h2>Flexible Classes</h2>
            <p>Our platform offers flexible class schedules that suit your availability, so you can learn at your own pace.</p>
        </div>
        <div class="inner-box">
            <h2>Expert Tutors</h2>
            <p>Learn from experienced tutors who are experts in their fields, offering personalized attention.</p>
        </div>
        <div class="inner-box">
            <h2>Real-world Projects</h2>
            <p>Work on real-world projects and case studies to gain hands-on experience and practical skills.</p>
        </div>
        <div class="inner-box">
            <h2>Certifications</h2>
            <p>Earn certifications recognized by top employers, which can boost your career and enhance your resume.</p>
        </div>
    </div>

    <div class="about-button">
        <a href="index.php" class="btn">Know More About Us</a>
    </div>
</div>

 
<?php include 'component/footer.php';
?>
<script src="js/user_script.js"></script>
</body>
</html>