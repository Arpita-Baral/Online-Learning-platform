<?php
    include '../component/connect.php';
    if(isset($_COOKIE['tutor_id'])){
        $tutor_id=$_COOKIE['tutor_id'];
    }else{
        $tutor_id='';
        header('location:login.php');
    }
     if (isset($_GET['get_id'])) 
     {
         $get_id = $_GET['get_id'];
     }
     else{ 
        header('location:playlists.php');
    } 
    
//delete 

if (isset($_POST['delete_video'])) {
    $delete_id = $_POST['video_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $verify_video = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1"); $verify_video->execute([$delete_id]);
    if ($verify_video->rowCount() > 0) {
    $delete_video_thumb = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1"); $delete_video_thumb->execute([$delete_id]);
    $fetch_thumb = $delete_video_thumb->fetch (PDO:: FETCH_ASSOC);
    unlink('../upload file/'.$fetch_thumb [ 'thumb']);//check this one later...
    

    $delete_video= $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
    $delete_video->execute([$delete_id]);
    $fetch_video= $delete_video->fetch (PDO:: FETCH_ASSOC);
    unlink('../upload file/'.$fetch_video['video']);
    $delete_likes = $conn->prepare("SELECT * FROM `likes` WHERE content_id = ?"); $delete_likes->execute([$delete_id]);
    $delete_comments = $conn->prepare("SELECT * FROM `comment` WHERE content_id = ?");
    $delete_comments->execute([$delete_id]);
    $delete_content = $conn->prepare("DELETE FROM `content` WHERE id = ?");
    $delete_content->execute([$delete_id]);
    $message[] = 'video deleted';
    }else{
    $message[] = 'video already deleted';
    }
    }

    if (isset($_POST['delete_comment'])) {
        $delete_id = $_POST['delete_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
        $verify_comment = $conn->prepare("SELECT * FROM `comment` WHERE id = ?"); 
        $verify_comment->execute([$delete_id]);
        if ($verify_comment->rowCount() > 0) {
        $delete_comment = $conn->prepare("DELETE FROM `comment` WHERE id = ?"); 
        $delete_comment->execute([$delete_id]); $message[] = 'comment deleted successfully';
        }else{
        $message[] = 'comment already deleted';
        }}
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
    <section class="view-content">
    <h1 class="heading"> Contents Details</h1>
    <?php
        $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ? AND tutor_id=?"); 
        $select_content->execute([$get_id,$tutor_id]);
        if ($select_content->rowCount() > 0) {
        while($fetch_content = $select_content->fetch (PDO:: FETCH_ASSOC))
        { $video_id = $fetch_content['id'];
        $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ? AND
        content_id = ?");
        $count_likes->execute([$tutor_id, $video_id]);
        $total_likes=$count_likes->rowCount();
       
       $count_comments = $conn->prepare("SELECT * FROM `comment` WHERE tutor_id = ? AND
        content_id = ?");
        $count_comments->execute([$tutor_id, $video_id]);
        $total_comments=$count_comments->rowCount();
        ?>
        <div class="container">
            <video src="../upload file/<?= $fetch_content['video']; ?>" autoplay controls poster="../upload file/<?= $fetch_content['thumb']; ?> " ></video>
            <div class="date"> <i class="bx bx-calendar"></i> <span> <?= $fetch_content['date']; ?></span> </div>
            <h3 class="title"><?= $fetch_content['title']; ?></h3>
            <div class="flex">
            <div><i class="bx bxs-heart"></i> <span><?= $total_likes; ?></span> </div> <div><i class="bx bxs-chat"></i><span><?= $total_comments; ?></span> </div>
            </div>
            <div class="description">
            <?= $fetch_content['description']; ?>
            </div>
            <form action="" method="post">
            <input type="hidden" name="video_id" value="<?= $video_id; ?>">
            <a href="update_content.php?get_id<?= $video_id; ?>" class="btn">update</a>
            <input type="submit" name="delete_video" value="delete video" class="btn" onclick=" return confirm ('delete this video');">
            </form>
        </div>
        <?php
        }
    }else{
        echo '<div class="empty">
                <p style="margin-bottom:1.5rem;">No Video Added Yet!</p>
                <a href="addcontent.php" class="btn" style="margin-top:1.5rem;">Add Videos</a>
            </div>';
        }  ?>   
        
   
        
    </section>
    <section class="comments">
            <h1 class="heading">user comments</h1>
            <div class="show-comments">
            <?php
            $select_comments = $conn->prepare("SELECT * FROM `comment` WHERE content_id=?");
             $select_comments->execute([$get_id]);
            if ($select_comments->rowCount() > 0) {
            
            while($fetch_comment =$select_comments->fetch(PDO::FETCH_ASSOC)){
                $select_commentor = $conn->prepare("SELECT * FROM `user` WHERE id=?");
                $select_commentor->execute([$fetch_comment['user_id']]);
                 $fetch_commentor = $select_commentor->fetch (PDO:: FETCH_ASSOC);
                
                ?>
                <div class="box">
                <div class="user">
                <!-- <img src="../upload file/<?= $fetch_commentor['image']; ?>">  -->
                <div>
                <h3> <?= $fetch_commentor['name']; ?></h3>
                <span> <?= $fetch_comment['date']; ?></span>
                </div>
                </div>
                <p class="text"> <?= $fetch_comment['comment']; ?></p>
                <form action="" method="post" class="flex-btn">
                <input type="hidden" name="delete_id" value="<?= $fetch_comment['id']; ?>">
                 <button type="submit" name="delete_comment" value="delete_comment" class="btn" onclick="return confirm('delete this comment');">Delete comment</button>
                </form>
                </div>

            ?>
            <?php
            }
            }else{
            echo '<p class="empty">No Comment Added Yet!</p>';
            }
            ?>
            </div>
            </section>
    <?php include '../component/footer.php';?>

    <script src="../js/admin_script.js"></script>
</body>
</html>