<?php
    include '../component/connect.php';
    if(isset($_POST['submit'])){
        $id=unique_id() ;
        $name=$_POST['name'];
        $name=filter_var($name,FILTER_SANITIZE_STRING);
        $profession=$_POST['profession'];
        $profession=filter_var($profession,FILTER_SANITIZE_STRING);
        $email=$_POST['email'];
        $email=filter_var($email,FILTER_SANITIZE_EMAIL);
        $pass = $_POST['pass']; 
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);// No hashing here
      $cpass = $_POST['cpass'];
      $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
        $image=$_FILES['image']['name'];
        $image=filter_var($image,FILTER_SANITIZE_STRING);
        $ext=pathinfo($image,PATHINFO_EXTENSION);
        $rename=unique_id().'.'.$ext;
        $image_size=$_FILES['image']['size'];
        $image_tmp_name=$_FILES['image']['tmp_name'];
        $image_folder='../upload file/'.$rename;
        $select_tutor=$conn->prepare("SELECT * FROM `tutors` WHERE email=?");
        $select_tutor->execute([$email]);
        if($select_tutor->rowCount()> 0){
            $message[]='Email already exist';
        }else{
            if($pass!=$cpass)
            {
            $message[]='Password Mismatch';
        }
        else{
            $insert_tutor=$conn->prepare("INSERT INTO tutors(id,name,profession, email,password,image) values(?,?,?,?,?,?)");
            $insert_tutor->execute([$id,$name,$profession,$email,$pass,$rename]);
            move_uploaded_file($image_tmp_name,$image_folder);
            $message[]= "New user Registered";
        }
    }
}
    
    ?>
<style type="text/css">
    <?php  include '../style/style1.css';  ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php
        if (isset($message)) {
            foreach ($message as $msg) {
                echo '
                    <div class="message">
                        <span>' . $msg . '</span>
                        <i class="bx bx-x" onclick="this.parentElement.remove();"></i>
                    </div>';
            }
        }
    ?>
    <div class="form-container">
        <img src="../image/fun.jpg" class="form-img" style="left:-7%">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>Register Now</h3>
            <div class="flex">
                <div class="col">
                    <p>Your Name<span>*</span></p>
                    <input type="text" name="name" placeholder="Enter Your Name" maxlength="50" required class="box">
                    <p>Your Profession</p>
                    <select name="profession" id=""required class="box">
                        <option value="" disabled selected>-select profession</option>
                        <option value="student">Student</option>
                        <option value="devloper">Developer</option>
                        <option value="working">Woorking Professional</option>
                        <option value="teacher">Teacher</option>
                        <option value="content">Content creator</option>
                        <option value="software">Software Developer</option>
                    </select>
                <p>Your Email<span>*</span></p>
                    <input type="email" name="email" placeholder="Enter Your Email" maxlength="50" required class="box">
                </div>
                <div class="col">
                <p>Your Password<span>*</span></p>
                <input type="password" name="pass" placeholder="Enter Your Password" maxlength="20" required class="box">
                <p>Confirm Your Password<span>*</span></p>
                <input type="password" name="cpass" placeholder="Confirm Your Password" maxlength="20" required class="box">
                <p>Select your picture<span>*</span></p>
                <input type="file" name="image" accept="image/*" required class="box">
                </div>
                
            </div>
            <p class="link">Already have an account?<a href="login.php">Login now</a></p>
                <input type="submit" name="submit" class="btn" value="Register now">
        </form>
    </div>
</body>
</html>