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
    $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
    $select_likes->execute([$user_id]);
    $total_likes = $select_likes->rowCount();
   
    $select_comments = $conn->prepare("SELECT * FROM `comment` WHERE user_id =?"); 
    $select_comments->execute([$user_id]);
    
    $total_comments = $select_comments->rowCount();

    $select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
    $select_bookmark->execute([$user_id]);
    $total_bookmarked = $select_bookmark->rowCount();
   
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
        <h1>About our Courses</h1>
        <div class="flex-btn">
            <a href="login.php" class="btn">Login to Start</a>
            <a href="contact.php" class="btn">Contact us</a>
        </div>
    </div>
    <img src="image/about.png" alt="">
</div>
<div class="categories"> 
<div class="heading">
<span>categories</span>
<h1>explore top courses categories <br>that change yourself</h1>
</h1>
</div>
<div class="box-container">
<div class="box">
<img src="image/web-design.png">
<h3>web design</h3>
<a href="courses.php">25 courses <i class="bx bx-right-arrow-alt"></i></a>
 </div>
<div class="box">
<img src="image/design.png">
<h3>graphic design</h3>
<a href="courses.php">30 courses <i class="bx bx-right-arrow-alt"></i></a>
</div>

<div class="box">
<img src="image/server.png">
<h3>IT and Software</h3>
<a href="courses.php">25 courses <i class="bx bx-right-arrow-alt"></i></a>
</div>
<div class="box">
<img src="image/paint-palette.png">
<h3>Graphic design</h3>
<a href="courses.php">25 courses <i class="bx bx-right-arrow-alt"></i></a>
</div>
<div class="box">
<img src="image/smartphone.png">
<h3>Mobile application</h3>
<a href="courses.php">25 courses <i class="bx bx-right-arrow-alt"></i></a>
</div>
<div class="box">
<img src="image/infographic.png">
<h3>Finance course</h3>
<a href="courses.php">25 courses <i class="bx bx-right-arrow-alt"></i></a>
</div>
<div class="box">
<img src="image/server.png">
<h3>IT and Software</h3>
<a href="courses.php">25 courses <i class="bx bx-right-arrow-alt"></i></a>
</div>
<div class="box">
<img src="image/design.png">
<h3>graphic design</h3>
<a href="courses.php">30 courses <i class="bx bx-right-arrow-alt"></i></a>
</div>
<div class="box">
<img src="image/smartphone.png">
<h3>Mobile application</h3>
<a href="courses.php">25 courses <i class="bx bx-right-arrow-alt"></i></a>
</div>
<div class="box">
<img src="image/design.png">
<h3>graphic design</h3>
<a href="courses.php">30 courses <i class="bx bx-right-arrow-alt"></i></a>
</div>
</div>
</div> 
<div class="courses">
    <div class="heading">
        <span>Top Popular Course</span>
        <h1>Courses Student <br> can join with us</h1>
    </div>
    <div class="box-container">
    <?php
        $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? ORDER BY date DESC "); 
        $select_courses->execute(['active']); 
        if($select_courses->rowCount() > 0){
        while($fetch_courses=$select_courses->fetch(PDO::FETCH_ASSOC)){
        $course_id = $fetch_courses['id'];
        $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id=?"); 
        $select_tutor->execute([$fetch_courses['tutor_id']]);
        $fetch_tutor=$select_tutor->fetch(PDO::FETCH_ASSOC);
    
    ?>
    <div class="box">
            <div class="tutor">
                <img src="upload file/<?= $fetch_tutor['image'] ?>" alt="">
            </div>
            <div>
                <h3>
                   <?= $fetch_tutor['name']; ?> 
                </h3>
                <span>  <?= $fetch_courses['date']; ?> </span>
            </div>
            <img src="upload file/<?= $fetch_courses['thumb']; ?>" class="thumb">
            <h3 class="title"><?= $fetch_courses['title']; ?> </h3>
            <a href="playlists.php? get_id=<?= $course_id; ?>" class="btn">View Playlist</a>
    </div>
    <?php 
        }
    }else{
        echo'<p class="empty"> No Course Added Yet!';
    }
    ?>
    </div>
    <div class="more-btn">
        <a href="courses.php" class="btn">View More</a>
    </div>
</div>
 
<?php include 'component/footer.php';
?>
<script src="js/user_script.js"></script>
</body>
</html>