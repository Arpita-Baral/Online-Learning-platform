<?php
    include '../component/connect.php';
    if(isset($_COOKIE['tutor_id'])){
        $tutor_id=$_COOKIE['tutor_id'];
    }else{
        $tutor_id='';
    }
    $select_profile = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
    $select_profile->execute([$tutor_id]);
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC); 
    /*cht*/
    $select_contents=$conn->prepare("SELECT * FROM `content` WHERE tutor_id= ?");
    $select_contents->execute([$tutor_id]);
    $total_contents = $select_contents->rowCount();

    $select_playlists=$conn->prepare("SELECT * FROM `playlist` WHERE tutor_id= ?");
    $select_playlists->execute([$tutor_id]); 
    $total_playlists=$select_playlists -> rowCount();

    $select_likes=$conn->prepare("SELECT * FROM `likes` WHERE tutor_id= ?");
    $select_likes->execute([$tutor_id]);
    $total_likes=$select_likes -> rowCount();

    $select_comments=$conn->prepare("SELECT * FROM `comment` WHERE tutor_id= ?");
    $select_comments->execute([$tutor_id]);
    $total_comments=$select_comments -> rowCount();
?>
<style type="text/css">
    <?php  include '../style/style1.css';  ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- <link rel="stylesheet" href="../style/style1.css"> -->
</head>
<body>
    <?php include '../component/admin_header.php';?>
    <section class="tutor-profile" style="min-height(100vh-19rem);">
        <h1 class="heading">Profile Details</h1>
        <div class="details">
            <div class="tutor">
                <img src="../upload file/<?=$fetch_profile['image']; ?>" >
                <h3><?= $fetch_profile['name'];?></h3>
                <span><?=$fetch_profile['profession']; ?></span>
                <a href="update.php" class="btn">Update Profile</a>
            </div>
        <div class="flex">
            <div class="box">
                <span><?= $total_playlists; ?> </span>
                <p>Total playlist</p>
                <a href="playlists.php" class="btn">View Playlist</a>
            </div>
            <div class="box">
                <span><?= $total_contents; ?> </span>
                <p>Total Videos</p>
                <a href="contents.php" class="btn">View Contents</a>
            </div>
            <div class="box">
                <span><?= $total_likes; ?> </span>
                <p>Total Likes</p>
                <a href="contents.php" class="btn">View Likes</a>
            </div>
            <div class="box">
                <span><?= $total_comments; ?> </span>
                <p>Total Comments</p>
                <a href="comments.php" class="btn">View Comments</a>
            </div>
        </div>
        </div>
            
    </section>
    <?php include '../component/footer.php';?>

    <script src="../js/admin_script.js"></script>
</body>
</html>