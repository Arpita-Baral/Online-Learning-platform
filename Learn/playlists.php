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
    if (isset($_GET['get_id'])) { 
    $get_id = $_GET['get_id'];
    }else{
    $get_id = '';
    header('location:index.php');
}
if(isset($_POST['save-list'])){
    if($user_id!=''){
        $list_id = $_POST['list_id'];
        $list_id = filter_var($list_id, FILTER_SANITIZE_STRING);
        $select_list = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id=? AND playlist_id=?");
        $select_list->execute([$user_id, $list_id]);
        
        if ($select_list->rowCount() > 0) {
            $remove_bookmark = $conn->prepare("DELETE FROM `bookmark` WHERE user_id=? AND playlist_id=?");
            $remove_bookmark->execute([$user_id, $list_id]);
            $message[] = 'playlist removed';
            }
        else{ 
            $insert_bookmark = $conn->prepare("INSERT INTO `bookmark` (user_id, playlist_id) VALUES(? ,?)");
            $insert_bookmark->execute([$user_id, $list_id]); 
            $message[] = 'playlist saved';
        } 
      }else{
           $message[] = 'please login first';
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
<!-- playlist section -->
 <section class="playlist">
    <div class="heading">
        <h1>Playlist Details</h1>
    </div>
<div class="row">
    <?php    
    $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id=? AND status=? LIMIT 1");
    $select_playlist->execute([$get_id, 'active']);
    if($select_playlist->rowCount() > 0){
    
    $fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);
    $playlist_id = $fetch_playlist['id'];
    
    $count_videos = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
    $count_videos->execute([$playlist_id]);
    $total_videos = $count_videos->rowCount();

    $select_tutor= $conn->prepare("SELECT * FROM `tutors` WHERE id=? LIMIT 1"); 
    $select_tutor->execute([$fetch_playlist['tutor_id']]);
    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
    $select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id=? AND playlist_id = ?");
    $select_bookmark->execute([$user_id, $playlist_id]);

    ?>
    <div class="col">
        <form action="" method="post" class="save-list">
        <input type="hidden" name="list_id" value="<?= $playlist_id; ?>">
        <?php
       if ($select_bookmark->rowCount() > 0) {
        ?>
        <button type="submit" name="save-list"><i class="bx bxs-bookmarks"></i> <span> saved</span>
     </button>
        <?php }
        else{ ?>
        <button type="submit" name="save-list"><i class="bx bxs-bookmarks"></i><span>save playlist</span></button>
        <?php } ?>
        </form>
        <div class="thumb">
        <span> <?= $total_videos; ?></span>
        <img src="upload file/<?= $fetch_playlist['thumb']; ?>">
       </div>
    </div>
    <div class="playlist-col">
        <div class="tutor">
        <img src="upload file/<?= $fetch_tutor['image']; ?>">
        <div>
        <h3><?= $fetch_tutor['name']; ?></h3>
        <span> <?= $fetch_tutor['profession']; ?></span>
        </div>
        </div>
        <div class="detail">
        <h3><?= $fetch_playlist['title']; ?></h3>
        <p><?= $fetch_playlist['description']; ?></p>
        <div class="date"> <i class="bx bxs-calendar-alt"></i>
        <span><?= $fetch_playlist['date']; ?></span> </div>
        </div>
        </div> 
    <?php

    ?>
    </div>
    
       
        <?php }
        else{
        echo '<p class="empty">this playlist was not found</p>';
        }?></div>
 </section>
 <section class="video-container">
    <div class="heading">
        <h1>Playlist Videos</h1>
    </div>
    <div class="box-container">
        <?php
        $select_content = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ? AND status = ?");
        $select_content->execute([$get_id, 'active']);
        if ($select_content->rowCount() > 0) {
        while($fetch_content= $select_content->fetch(PDO::FETCH_ASSOC)){
        ?>
        <a href="watch-video.php?get_id=<?= $fetch_content['id']; ?>" class="box"> <i class='bx bx-play'></i>
        <img src="upload file/<?= $fetch_content['thumb']; ?>">
        <h3> <?= $fetch_content['title']; ?></h3>
        </a>
        <?php
        } }else{
        echo '<p class="empty">no videos added yet!</p>';
        }
        ?> 
    </div>
 </section>
<?php include 'component/footer.php';
?>
<script src="js/user_script.js"></script>
</body>
</html>