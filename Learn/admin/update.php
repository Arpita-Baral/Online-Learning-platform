<?php
include '../component/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
}

if(isset($_POST['submit'])){
    // Fetch the tutor information
    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ? LIMIT 1");
    $select_tutor->execute([$tutor_id]);
    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

    // Check if the tutor data was fetched successfully
    if ($fetch_tutor) {
        $prev_pass = $fetch_tutor["password"];
        $prev_image = $fetch_tutor["image"];

        // Sanitize input values
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $profession = filter_var($_POST['profession'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        // Update name if not empty
        if(!empty($name)){
            $update_name = $conn->prepare("UPDATE `tutors` SET name=? WHERE id = ?");
            $update_name->execute([$name, $tutor_id]);
            $message[] = 'Username updated successfully';
        }

        // Update profession if not empty
        if(!empty($profession)){
            $update_profession = $conn->prepare("UPDATE `tutors` SET profession =? WHERE id = ?");
            $update_profession->execute([$profession, $tutor_id]);
            $message[] = 'User profession updated successfully';
        }

        // Update email if not empty
        if(!empty($email)){
            // Check if the email already exists
            $select_email = $conn->prepare("SELECT * FROM `tutors` WHERE email=? AND id != ?");
            $select_email->execute([$email, $tutor_id]);
            if($select_email->rowCount() > 0){
                $message[] = "Email already taken";
            } else {
                $update_email = $conn->prepare("UPDATE `tutors` SET email =? WHERE id = ?");
                $update_email->execute([$email, $tutor_id]);
                $message[] = 'User email updated successfully';
            }
        }

        // Handle image upload and update
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = uniqid().'.'.$ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../upload file/'.$rename;

        if(!empty($image)){
            if($image_size > 2000000){
                $message[] = 'Image size too large';
            } else {
                $update_image = $conn->prepare("UPDATE `tutors` SET `image` = ? WHERE id = ?");
                $update_image->execute([$rename, $tutor_id]);
                move_uploaded_file($image_tmp_name, $image_folder);
                if($prev_image != '' && $prev_image != $rename){
                    unlink('../upload file/'.$prev_image);
                }
                $message[] = 'Image updated successfully';
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
                    $update_pass = $conn->prepare("UPDATE `tutors` SET `password` = ? WHERE id = ?");
                    $update_pass->execute([$new_pass, $tutor_id]);
                    $message[] = "Password updated successfully";
                } else {
                    $message[] = "Please enter a new password";
                }
            }
        }
    } else {
        $message[] = 'Tutor not found';
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
    <title>update profile</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<?php include '../component/admin_header.php';?>
    <div class="form-container" style="min-height:calc(100vh-19rem); padding:5rem 0;">
        
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>Update Profile</h3>
            <div class="flex">
                <div class="col">
                    <p>Your Name<span>*</span></p>
                    <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="50" required class="box">
                    <p>Your Profession</p>
                    <select name="profession" id=""required class="box">
                        <option value="" disabled selected>"<?= $fetch_profile['profession']; ?>" </option>
                        <option value="student">Student</option>
                        <option value="devloper">Developer</option>
                        <option value="working">Woorking Professional</option>
                        <option value="teacher">Teacher</option>
                        <option value="content">Content creator</option>
                        <option value="software">Software Developer</option>
                    </select>
                <p>Your Email<span>*</span></p>
                    <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" maxlength="50" required class="box">
                </div>
                <div class="col">
                <p>Your Old Password<span>*</span></p>
                <input type="password" name="pass" placeholder="Enter your old password"  maxlength="20" required class="box">
                <p> Your new Password<span>*</span></p>
                <input type="password" name="new_pass" placeholder="Enter Your new Password" maxlength="20" required class="box">
                <p>Confirm Your Password<span>*</span></p>
                <input type="password" name="cpass" placeholder="Confirm Your Password" maxlength="20" required class="box">
                
                </div>
                
            </div>
            <p>Update your picture<span>*</span></p>
                <input type="file" name="image" accept="image/*" required class="box">
                <input type="submit" name="submit" class="btn" value="Update Profile">
        </form>
    </div>
    <?php include '../component/footer.php';?>

    <script src="../js/admin_script.js"></script>
</body>
</html>