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
    
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $user_message = $_POST['msg'];
    $user_message = filter_var($user_message, FILTER_SANITIZE_STRING);
    $select_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ? AND email = ? AND number= ? AND message=?");
    $select_contact->execute([$name, $email, $number, $user_message]);
    if ($select_contact->rowCount() > 0) {
    $message[] ='message already sent';
    }else{
    $insert_message = $conn->prepare("INSERT INTO `contact` (name, email, number, message) VALUES(?,?,?,?)");
    $insert_message->execute([$name, $email, $number, $user_message]);
    $message[] = 'message sent';
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
    <title>Contact Page</title>
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
        <h1> Now Contact us</h1>
        <div class="flex-btn">
            <a href="login.php" class="btn">Login to Start</a>
           
        </div>
    </div>
    <img src="image/about.png" alt="">
</div>
<!-- register section -->
<section class="contact"></section>
    
<form action="" method="post" enctype="form-container"> <div class="heading">
<span>education for everyone</span>
<h1>Get a Free Course You Can Contact With Me</h1>
<div class="input-field">
<p>name <span>*</span> </p>
<input type="text" name="name" maxlength="100" required class="box"> </div>
<div class="input-field">
<p>email <span>*</span> </p>
<input type="email" name="email" maxlength="100" required class="box"> </div>
<div class="input-field">
<p>number <span>*</span> </p>
<input type="number" name="number" min="0" maxlength="10" max="9999999999" required class="box">
</div>
<div class="input-field">
<p>message <span>*</span> </p>
<textarea name="msg" cols="30" rows="10" maxlength="1000" class="box" rows=" "></textarea>
</div>
<input type="submit" name="submit" value=" Get in Touch" class="btn"> </form>
</div>
 
<?php include 'component/footer.php';
?>
<script src="js/user_script.js"></script>
</body>
</html>