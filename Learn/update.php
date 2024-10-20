<?php 
    include 'component/connect.php';

    if(isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
        header('location:login.php');
    }
   
    if(isset($_POST['submit'])){
        // Fetch the tutor information
        $select_user = $conn->prepare("SELECT * FROM `user` WHERE id = ? LIMIT 1");
        $select_user->execute([$user_id]);
        $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    
        // Check if the tutor data was fetched successfully
        if ($fetch_user) {
            $prev_pass = $fetch_user["password"];
            
    
            // Sanitize input values
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
           
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
            // Update name if not empty
            if(!empty($name)){
                $update_name = $conn->prepare("UPDATE `user` SET name=? WHERE id = ?");
                $update_name->execute([$name, $user_id]);
                $message[] = 'Username updated successfully';
            }
    
            
    
            // Update email if not empty
            if(!empty($email)){
                // Check if the email already exists
                $select_email = $conn->prepare("SELECT * FROM `user` WHERE email=? AND id != ?");
                $select_email->execute([$email, $user_id]);
                if($select_email->rowCount() > 0){
                    $message[] = "Email already taken";
                } else {
                    $update_email = $conn->prepare("UPDATE `user` SET email =? WHERE id = ?");
                    $update_email->execute([$email, $user_id]);
                    $message[] = 'User email updated successfully';
                }
            }
    
           
            // Password change logic
            $empty_pass = '';
           // $old_pass = sha1($_POST['old_pass']);
            //$old_pass == filter_var($old_pass, FILTER_SANITIZE_STRING);
            $new_pass = $_POST['new_pass'];
            $new_pass == filter_var($new_pass, FILTER_SANITIZE_STRING);
            $cpass = $_POST['cpass'];
            $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
    
            //if($old_pass != $empty_pass){
                if($new_pass != $cpass){
                    $message[] = 'Confirm password does not match';
                } else {
                    if($new_pass != $empty_pass){
                        $update_pass = $conn->prepare("UPDATE `user` SET `password` = ? WHERE id = ?");
                        $update_pass->execute([$new_pass, $user_id]);
                        $message[] = "Password updated successfully";
                    } else {
                        $message[] = "Please enter a new password";
                    }
                }
            }
        } else {
            $message[] = 'User not found';
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
            <a href="index.php">Home</a><span><i class="bx bx-chevron-right"></i>Update Now</span>
        </div>
        <h1>Update Profile </h1>
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
        <span>Join with us</span>
        <h1>Update Account</h1>
    </div>
<form class="register" method="post" enctype="multipart/form-data">
    <div class="flex">
        <div class="col">
        <p>Your Name<span>*</span></p>
        <input type="text" name="name" placeholder="<?= $fetch_profile['name']?>" maxlength="50"  class="box">
        <p>Your Email<span>*</span></p>
        <input type="email" name="email" placeholder=" <?= $fetch_profile['email']?>" maxlength="50"  class="box">
        </div>
        <div class="col">
                <p>old Password<span>*</span></p>
                <input type="password" name="old_pass" placeholder="Enter Your Password" maxlength="20" required class="box">
                <p>new Password<span>*</span></p>
                <input type="password" name="new_pass" placeholder="Enter Your Password" maxlength="20" required class="box">
                <p>Confirm Your Password<span>*</span></p>
                <input type="password" name="cpass" placeholder="Confirm Your Password" maxlength="20" required class="box">
                
                </div>
    </div>
    
    <input type="submit" name="submit" class="btn" value="Update now">            
</form>

 </section>
 
<?php include 'component/footer.php';
?>
<script src="js/user_script.js"></script>
</body>
</html>