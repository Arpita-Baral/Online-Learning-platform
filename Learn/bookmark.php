<?php 
    include 'component/connect.php';

    if(isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
        header('location:login.php');
    }
    // $select_likes=$conn->prepare('SELECT * FROM `likes` WHERE user_id=?');
    // $select_likes->execute([$user_id]);
    // $total_likes=$select_likes->rowCount();

    // $select_comments=$conn->prepare('SELECT * FROM `comment` WHERE user_id=?');
    // $select_comments->execute([$user_id]);
    // $total_comments =$select_comments->rowCount();

    // $select_bookmark=$conn->prepare('SELECT * FROM `bookmark` WHERE user_id=?');
    // $select_bookmark->execute([$user_id]);
    // $total_bookmark =$select_comments->rowCount();
    
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
            <a href="index.php">Home</a><span><i class="bx bx-chevron-right"></i>playlist</span>
        </div>
        <h1>User playlist</h1>
        <div class="flex-btn">
            <a href="login.php" class="btn">Login to Start</a>
            <a href="contact.php" class="btn">Contact us</a>
        </div>
    </div>
    <img src="image/about.png" alt="">
</div>
<!-- Profile section -->
<section class="courses">
    <div class="heading">
        <h1>Bookmarked Playlist</h1>
    </div>
    <div class="box-container">
        <?php 
        $select_bookmark = $conn->prepare('SELECT * FROM `bookmark` WHERE user_id=?');
        $select_bookmark->execute([$user_id]);

        if ($select_bookmark->rowCount() > 0) {
            while ($fetch_bookmark = $select_bookmark->fetch(PDO::FETCH_ASSOC)) {
                $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE id=? AND status=? ORDER BY date DESC");
                $select_courses->execute([$fetch_bookmark['playlist_id'], 'active']);

                if ($select_courses->rowCount() > 0) {
                    while ($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)) {

                        // Fetch tutor id from the course
                        $tutor_id = $fetch_course['tutor_id']; 

                        $select_tutor = $conn->prepare('SELECT * FROM `tutors` WHERE id=?');
                        $select_tutor->execute([$tutor_id]);
                        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

                        if ($fetch_tutor) {
                            ?>
                            <div class="box">
                                <div class="tutor">
                                    <img src="upload file/<?= $fetch_tutor['image']; ?>"> 
                                    <div>
                                        <h3><?= $fetch_tutor['name']; ?></h3>
                                        <span><?= $fetch_tutor['profession']; ?></span>
                                    </div>
                                </div>
                                <img src="upload file/<?= $fetch_course['thumb']; ?>" class="thumb"> 
                                <h3 class="title"><?= $fetch_course['title']; ?></h3>
                                <a href="playlists.php?get_id=<?= $course_id; ?>">View playlist</a>
                            </div>
                            <?php
                        } else {
                            echo '<p class="empty">Tutor not found</p>';
                        }
                    }
                } else {
                    echo '<p class="empty">No course Found</p>';
                }
            }
        } else {
            echo '<p class="empty">Nothing Bookmarked</p>';
        }
        ?>
    </div>
</section>


 
<?php include 'component/footer.php';
?>
<script src="js/user_script.js"></script>
</body>
</html>