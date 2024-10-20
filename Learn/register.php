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
        $id=unique_id() ;
        $name=$_POST['name'];
        $name=filter_var($name,FILTER_SANITIZE_STRING);
        // $profession=$_POST['profession'];
        // $profession=filter_var($profession,FILTER_SANITIZE_STRING);
        $email=$_POST['email'];
        $email=filter_var($email,FILTER_SANITIZE_EMAIL);
        $pass = $_POST['pass']; 
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);// No hashing here
      $cpass = $_POST['cpass'];
      $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
        // $image=$_FILES['image']['name'];
        // $image=filter_var($image,FILTER_SANITIZE_STRING);
        // $ext=pathinfo($image,PATHINFO_EXTENSION);
        // $rename=unique_id().'.'.$ext;
        // $image_size=$_FILES['image']['size'];
        // $image_tmp_name=$_FILES['image']['tmp_name'];
        // $image_folder='../upload file/'.$rename;
        $select_user=$conn->prepare("SELECT * FROM `user` WHERE email=?");
        $select_user->execute([$email]);
        if($select_user->rowCount()> 0){
            $message[]='Email already exist';
        }else{
            if($pass!=$cpass)
            {
            $message[]='Password Mismatch';
        }
        else{
            $insert_user=$conn->prepare("INSERT INTO user(id,name, email,password) values(?,?,?,?)");
            $insert_user->execute([$id,$name,$email,$pass]);
            // move_uploaded_file($image_tmp_name,$image_folder);
            $message[]= "New user Registered";
            $verify_user = $conn->prepare("SELECT * FROM `user` WHERE email = ? AND password = ? LIMIT 1");
            $verify_user->execute([$email, $pass]);
            $row = $verify_user->fetch (PDO:: FETCH_ASSOC);
            if($verify_user->rowCount() > 0){
           
            setcookie('user_id', $row['id'], time() + 60*60*24*30, '/'); 
            header('location:index.php'); 
        }
        }
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
        <span>Join with us</span>
        <h1>Create Account</h1>
    </div>
<form class="register" method="post" enctype="multipart/form-data">
    <div class="flex">
        <div class="col">
        <p>Your Name<span>*</span></p>
        <input type="text" name="name" placeholder="Enter Your Name" maxlength="50" required class="box">
        <p>Your Email<span>*</span></p>
        <input type="email" name="email" placeholder="Enter Your Email" maxlength="50" required class="box">
        </div>
        <div class="col">
                <p>Your Password<span>*</span></p>
                <input type="password" name="pass" placeholder="Enter Your Password" minlength="6" required class="box">
                <p>Confirm Your Password<span>*</span></p>
                <input type="password" name="cpass" placeholder="Confirm Your Password" minlength="6" required class="box" id="pswd"><button id="toggle"><i class='bx bx-low-vision'></i></button>
                
                </div>
    </div>
    <!-- <p>Select your picture<span>*</span></p> -->
     <!-- <input type="file" name="image" accept="image/*" required class="box"> -->
     <p class="link">Already have an account?<a href="login.php">Login now</a></p>
    <input type="submit" name="submit" class="btn" value="Register now">            
</form>

 </section>
 
<?php include 'component/footer.php';
?>
<script src="js/user_script.js"></script>
</body>
</html>