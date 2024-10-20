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

   
?>
<style>
     <?php  include 'style/style2.css';  ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<?php include 'component/user_header.php';?>
<div class="banner">
    <div class="detail">
        <div class="title">
            <a href="index.php">Home</a><span><i class="bx bx-chevron-right"></i>Teachers</span>
        </div>
        <h1>Teachers</h1>
        <div class="flex-btn">
            <a href="login.php" class="btn">Login to Start</a>
            <a href="contact.php" class="btn">Contact us</a>
        </div>
    </div>
    <img src="image/about.png" alt="">
</div>
<!-- register section -->
 <section class="teachers">
    <div class="heading">
        <h1>Our Tutors</h1>
    </div>
    
    <div class="box-container">
        <div class="box">
            <h3>Be A Tutor</h3>
            <a href="admin/register.php">Get Started</a>
        </div>
        <?php 
        $select_tutor=$conn->prepare("SELECT *FROM `tutors`");
        $select_tutor->execute();
        if ($select_tutor->rowCount() > 0) {
            while($fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC)){
            $tutor_id = $fetch_tutor['id'];
            $count_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id= ?");
            $count_playlists->execute([$tutor_id]);
            $total_playlists=$count_playlists->rowCount();

            $count_content = $conn->prepare("SELECT * FROM `content` WHERE tutor_id= ?");
            $count_content->execute([$tutor_id]);
            $total_content=$count_playlists->rowCount();

            $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?"); $count_likes->execute([$tutor_id]);
            $total_likes = $count_likes->rowCount();
            $count_comments = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?"); $count_comments->execute([$tutor_id]); $total_comments = $count_likes->rowCount();
            ?>
            <div class="box">
                
        <div class="tutor">
            <img src="upload file/<?= $fetch_tutor['image']; ?>"> 
            <div>
            <h3><?= $fetch_tutor['name']; ?></h3>
            <span><?= $fetch_tutor['profession']; ?></span>
            </div>
            </div>
            <p>playlist: <span> <?= $total_playlists; ?></span></p> 
            <p>total videos: <span><?= $total_content; ?></span></p>
            <p>total likes: <span> <?= $total_likes; ?></span></p> 
            <p>total comments: <span> <?= $total_comments; ?></span></p>
            <!-- <form action="tutor_profile.php" method="post">
            <input type="hidden" name="tutor_email" value="<?= $fetch_tutor['email']; ?>">
            <input type="submit" name="view profile" name="tutor_fetch" class="btn"> </form> -->
            </div>
            <?php
            }
        }else{
            echo '<p class="empty">this playlist was not found</p>';
        }
        ?>
        
    </div>
 </section>
 
<?php include 'component/footer.php';
?>
<script src="js/user_script.js"></script>
</body>
</html>