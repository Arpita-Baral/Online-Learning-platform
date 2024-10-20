<?php 
    include 'component/connect.php';

    if(isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
        header('location:login.php');
    }
    

    $select_likes=$conn->prepare('SELECT * FROM `likes` WHERE user_id=?');
    $select_likes->execute([$user_id]);
    $total_likes=$select_likes->rowCount();

    $select_comments=$conn->prepare('SELECT * FROM `comment` WHERE user_id=?');
    $select_comments->execute([$user_id]);
    $total_comments =$select_comments->rowCount();

    $select_bookmark=$conn->prepare('SELECT * FROM `bookmark` WHERE user_id=?');
    $select_bookmark->execute([$user_id]);
    $total_bookmark =$select_comments->rowCount();
    
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
        <h1>User Profile</h1>
        <div class="flex-btn">
            <a href="login.php" class="btn">Login to Start</a>
            <a href="contact.php" class="btn">Contact us</a>
        </div>
    </div>
    <img src="image/about.png" alt="">
</div>
<!-- Profile section -->
 
<section class="profile"> 
    <div class="heading"> <h1>profile detail</h1>
</div>
<div class="details">
<div class="user">

<!-- <img src="upload file/<?= $fetch_profile['image']; ?>" >  -->

<h3><?= $fetch_profile['name']; ?></h3>
<p>student</p>
<a href="update.php" class="btn">update profile</a> </div>
<div class="box-container">
<div class="box">
    <div class="flex">
        <i class="bx bxs-bookmarks"></i>
        <h3><?= $total_bookmark;?></h3>
        <span>Saved Playlist</span>
    </div>
    <a href="bookmark.php" class="btn">View Playlist</a>

<div class="flex">
        <i class="bx bxs-heart"></i>
        <h3><?= $total_likes;?></h3>
        <span>Liked tutorial</span>
    </div>
    <!-- <a href="likes.php" class="btn">View Likes</a> -->
    <div class="flex">
        <i class="bx bxs-chat"></i>
        <h3><?= $total_comments;?></h3>
        <span>Video Comments</span>
    </div>
    <!-- <a href="comments.php" class="btn">View comments</a> -->
</div>
</div>


  </section>
 
<?php include 'component/footer.php';
?>
<script src="js/user_script.js"></script>
</body>
</html>