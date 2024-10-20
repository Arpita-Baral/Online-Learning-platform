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
        
     
if (isset($_POST['like_content'])) {
    if ($user_id) {
    $content_id = $_POST['content_id'];
    $content_id = filter_var($content_id, FILTER_SANITIZE_STRING);
    $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1"); 
    $select_content->execute([$content_id]);
    $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
    $tutor_id = $fetch_content[ 'tutor_id'];
    $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND content_id = ?" );
    $select_likes->execute([$user_id, $content_id]);
    if ($select_likes->rowCount() > 0) {
    $remove_likes = $conn->prepare("DELETE FROM `likes` WHERE user_id=?");
    $remove_likes->execute([$user_id]);
    $message[]='Likes Removed';
    }   else{
        $insert_likes = $conn->prepare("INSERT INTO `likes` (user_id, tutor_id, content_id) VALUES(?,?,?)");
        $insert_likes->execute([$user_id, $tutor_id, $content_id]);
        $message[] = 'added to likes!';
    }
}else{
    $message[] = 'Please Login to like';
}
}
if (isset($_POST['add_comment'])) {
    if ($user_id != '') {
    $id =unique_id();
    $comment_box = $_POST['comment_box'];
    $comment_box = filter_var($comment_box, FILTER_SANITIZE_STRING);
    $content_id = $_POST['content_id'];
    $content_id = filter_var($content_id, FILTER_SANITIZE_STRING);
    $select_content= $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
    $select_content->execute([$content_id]);
    $fetch_content= $select_content->fetch(PDO:: FETCH_ASSOC);
    $tutor_id = $fetch_content['tutor_id'];
    if ($select_content->rowCount() >0) {
        $select_comment = $conn->prepare("SELECT * FROM `comment` WHERE content_id=? AND user_id=? AND comment=?");
        $select_comment->execute([$content_id, $user_id, $comment_box]);
        if($select_comment->rowCount() > 0){
            $message[]='Comment added';
        }else{
            $insert_comment = $conn->prepare("INSERT INTO `comment` (id, content_id, user_id, tutor_id, comment) VALUES (?,?,?,?,?)");
        $insert_comment->execute([$id, $content_id, $user_id, $tutor_id, $comment_box]); 
        $message[] = 'new comment added';
        }
    }else{
        $message[]='Something went wrong';
    }
}else{
    $message[]= 'Log in First';
}
}

if (isset($_POST['delete_comment'])) {
    $delete_id = $_POST['comment_id'];
    $delete_id = filter_var($delete_id,FILTER_SANITIZE_STRING);
    $verify_comment = $conn->prepare("SELECT * FROM `comment` WHERE id = ?"); 
    $verify_comment->execute([$delete_id]);
    if($verify_comment->rowCount() > 0){
    $delete_comment=$conn->prepare("DELETE FROM`comment` where id=?");
    $delete_comment->execute([$delete_id]);
    $message[]= 'Comment Deleted';

}else{
    $message[]= 'Comment Already Deleted';
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
        <h1>Watch Video</h1>
        <div class="flex-btn">
            <a href="login.php" class="btn">Login to Start</a>
            <a href="contact.php" class="btn">Contact us</a>
        </div>
    </div>
    <img src="image/about.png" alt="">
</div>
<!-- playlist section -->
 <section class="watch-video">
 <?php
    $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ? AND status = ?"); 
    $select_content->execute([$get_id, 'active']);
    if ($select_content->rowCount() > 0) {
    while($fetch_content= $select_content->fetch(PDO::FETCH_ASSOC)){
    $content_id = $fetch_content['id'];
    $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE content_id = ?");
    $select_likes->execute([$content_id]);
    $total_likes = $select_likes->rowCount();
    $verify_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id=? AND content_id=? ");
    $verify_likes->execute([$user_id, $content_id]);
    
$select_tutor = $conn->prepare("SELECT *
FROM `tutors` WHERE id = ? LIMIT 1");
 $select_tutor->execute([$fetch_content['tutor_id']]);
$fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
?>
<div class="video-details">
    <video src="upload file/<?= $fetch_content['video']; ?>" class="video" poster="upload file/<?$fetch_content['thumb']; ?>" controls autoplay></video>
    <h3 class="title"><?= $fetch_content['thumb']; ?></h3>
    <div class="info">
        <p><i class="bx bxs-calender-alt"><span><?= $fetch_content['date']?></span></i></p>
        <p><i class="bx bxs-heart"><span><?= $total_likes; ?></span></i></p>
    </div>
    <div class="tutor">
        <img src="upload file/<?= $fetch_tutor['image']; ?>"> 
        <div>
        <h3><?= $fetch_tutor['name']; ?></h3>
        <span> <?= $fetch_tutor['profession']; ?></span>
        </div>
    </div>
    <form action="" method="post" class="flex">
<input type="hidden" name="content_id" value="<?= $content_id; ?>">
<a href="playlist.php?get_id=<?= $fetch_content['playlist_id']; ?>" class="btn">view playlist</a>
<?php if($verify_likes->rowCount() > 0) 
{ ?> <button type="submit" name="like_content"><i class="bx_bxs-heart"></i> <span>liked</ span></button>
<?php }
else{ ?>
<button type="submit" name="like_content"><i class="bx bxs-heart"></i> <span>like</ span></button>
<?php } ?>
</form>
<div class="description"><p><?= $fetch_content['description']; ?></p></div>
</div>
<?php
  }
}else{
    echo '<p class="empty">no videos added yet!</p>';
}
?>
 </section>
 <!-- comment section -->
  
<section class="comments"> <div class="heading">
<h1>add a comment</h1> </div>
<form action="" method="post" class="add-comment">
<input type="hidden" name="content_id" value="<?= $get_id; ?>">
<textarea name="comment_box" required placeholder="write your comment.." maxlength="1000" cols="30" rows="10"></textarea>
<input type="submit" name="add_comment" class="btn" value="add_comment">
</form>
<div class="heading">
<h1>user comments</h1>
</div>
<div class="show-comments">
    <?php
    $select_comments = $conn->prepare("SELECT * FROM `comment` WHERE content_id = ?");
    $select_comments->execute([$get_id]);

    if ($select_comments->rowCount() > 0) {
        // Fetch and display comments
        while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
            $select_commentor = $conn->prepare("SELECT * FROM `user` WHERE id = ?");
            $select_commentor->execute([$fetch_comment['user_id']]);
            $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
    ?>
            <div class="box" style="<?php if($fetch_comment['user_id'] == $user_id){ echo 'order:-1'; } ?>">
                <div class="user">
                    <!-- <img src="upload file/<?= $fetch_commentor['image']; ?>"> -->
                    <div>
                        <h3><?= $fetch_commentor['name']; ?></h3>
                        <span><?= $fetch_comment['date']; ?></span>
                    </div>
                </div>
                <p class="text"><?= $fetch_comment['comment']; ?></p>
                <?php if ($fetch_comment['user_id'] == $user_id) { ?>
                    <form action="" method="post" class="flex-btn">
                        <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
                        <!-- <button type="submit" name="edit_comment" class="btn">Edit Comment</button> -->
                        <button type="submit" name="delete_comment" class="btn" onclick="return confirm('Are you sure you want to delete this comment?');">Delete Comment</button>
                    </form>
                <?php } ?>
            </div>
    <?php 
        }
    } else {
        echo '<p class="empty">No comments added yet!</p>';
    }
    ?>
</div>

</section>
<?php include 'component/footer.php';
?>
<script src="js/user_script.js"></script>
</body>
</html>