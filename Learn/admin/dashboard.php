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
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- <link rel="stylesheet" href="../style/style1.css"> -->
</head>
<body>
    <?php include '../component/admin_header.php';?>
    <section class="dashboard">
        <h1 class="heading">Dashboard</h1>
        <div class="box-container">
            <div class="box">
                <h3>WELCOME</h3>
                <!-- <P><?= $fetch_profile['name'];?></P> -->
                  <!-- Check if profile data exists before trying to access it -->
                <p><?= isset($fetch_profile['name']) ? $fetch_profile['name'] : 'No profile found'; ?></p>
                <a href="profile.php" class="btn">View Profile</a>
            </div>
        <div class="box">
              <h3><?= $total_contents;?></h3>
              <p>Total Contents</p>
                <a href="addcontent.php" class="btn">Add new Content</a>
        </div>
        <div class="box">
              <h3><?= $total_playlists;?></h3>
              <p>Total Playlists</p>
                <a href="addplaylist.php" class="btn">Add new Playlist</a>
        </div>
        <div class="box">
              <h3><?= $total_likes;?></h3>
              <p>Total Likes</p>
            <a href="contents.php" class="btn">View Contents</a>
        </div>
        <div class="box">
              <h3><?= $total_comments;?></h3>
              <p>Total Comments</p>
            <a href="comments.php" class="btn">View Comments</a>
        </div>
        <div class="box">
              <h3>Quick Start</h3>
              <div class="flex-btn">
                <a href="login.php" class="btn" style="width:200px">Login Now</a>
                <a href="register.php" class="btn" style="width:200px">Register Now</a>
              </div>
        </div>
        

        </div>
    </section>
    <?php include '../component/footer.php';?>

    <script src="../js/admin_script.js"></script>
</body>
</html>