<?php
    include '../component/connect.php';
    if(isset($_COOKIE['tutor_id'])){
        $tutor_id=$_COOKIE['tutor_id'];
    }else{
        $tutor_id='';
        header('location: login.php');
    }
    if (isset($_GET['get_id'])) 
     {
         $get_id = $_GET['get_id'];
     }
     else{ 
        header('location:playlists.php');
    }
    if (isset($_POST['update'])) {
        $video_id = $_POST['video_id'];
        $video_id = filter_var($video_id, FILTER_SANITIZE_STRING);
        $status = $_POST['status'];
        $status = filter_var($status, FILTER_SANITIZE_STRING);
        $title= $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING); 
        $description = $_POST["description"];
            $description = filter_var($description, FILTER_SANITIZE_STRING);
            $playlist = $_POST['playlist'];
            $playlist = filter_var($playlist, FILTER_SANITIZE_STRING);
            $update_content = $conn->prepare("UPDATE `content` SET title = ?, description = ?, status= ? WHERE id = ?");
            $update_content->execute([$title, $description, $status, $video_id]);
            if (!empty($playlist)) {
            $update_playlist = $conn->prepare("UPDATE `content` SET playlist_id=? WHERE id = ?"); 
            $update_playlist->execute([$playlist, $video_id]);
                
        }
        $old_thumb = $_POST['old_thumb'];
        $old_thumb = filter_var($old_thumb, FILTER_SANITIZE_STRING);
        $image = $_FILES['image']['name'];
        $image=filter_var($image, FILTER_SANITIZE_STRING);
        $image_ext = pathinfo($image, PATHINFO_EXTENSION); 
        $rename_image = unique_id().'.'.$image_ext; 
        $image_size = $_FILES['image']['size']; 
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder='../upload file/'.$rename_image;
        if (!empty($image)) {
        if ($image_size >2000000) {
            $message[] = 'image size is too large';
        }else{
        $update_thumb= $conn->prepare("UPDATE `content` SET thumb=? WHERE id = ?"); 
        $update_thumb->execute([$rename_image, $video_id]);
         move_uploaded_file($image_tmp_name, $image_folder);
        if ($old_thumb != '' AND $old_thumb != $rename_image) {
            unlink('../upload file/'.$old_thumb);
        }
        
    }
        }
        //video
        $old_video= $_POST['old_video'];
        $old_video= filter_var($old_video, FILTER_SANITIZE_STRING);
        $video = $_FILES['video']['name'];
        $video=filter_var($video, FILTER_SANITIZE_STRING);
        $video_ext = pathinfo($video, PATHINFO_EXTENSION); 
        $rename_video= unique_id().'.'.$video_ext;
        $video_tmp_name=$_FILES['video']['tmp_name'];
         $video_folder = '../upload file/'.$rename_video;
       
        if (!empty($video)) {
        $update_video= $conn->prepare("UPDATE `content` SET video = ? WHERE id =?");
        $update_video->execute([$rename_video, $video_id]); 
        move_uploaded_file($video_tmp_name, $video_folder);
        if ($old_video != '' AND $old_video != $rename_video) {
            unlink('../upload file/'.$old_video);
        
        }
        }
        $message[]='Content Uploaded .';
   
    } 
    if (isset($_POST['delete'])) {
   
    $delete_id = $_POST['video_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $delete_video_thumb = $conn->prepare("SELECT thumb FROM `content` WHERE id = ? LIMIT 1"); 
    $delete_video_thumb->execute([$delete_id]);
    $fetch_thumb = $delete_video_thumb->fetch (PDO::FETCH_ASSOC); 
    unlink('../upload file/'.$fetch_thumb['thumb']);
    
    $delete_video= $conn->prepare("SELECT video FROM `content` WHERE id = ? LIMIT 1"); 
    $delete_video->execute([$delete_id]);
    $fetch_video = $delete_video->fetch(PDO:: FETCH_ASSOC);
    unlink('../upload file/'.$fetch_video['video']);

    $delete_likes= $conn->prepare("DELETE FROM `likes` WHERE content_id=?"); 
    $delete_likes->execute([$delete_id]);
    $delete_comments= $conn->prepare("DELETE FROM `comment` WHERE content_id=?"); 
    $delete_comments->execute([$delete_id]);
    
    $delete_content=$conn->prepare("DELETE FROM `content` WHERE id=?");
    $delete_content->execute([$delete_id]);
    header("location:contents.php");

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
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- <link rel="stylesheet" href="../style/style1.css"> -->
</head>
<body>
    <?php include '../component/admin_header.php';?>
    <section class="video-form">
    <h1 class="heading">Upload Content</h1>
    <?php
        $select_video= $conn->prepare("SELECT * FROM `content` WHERE id =? AND tutor_id = ?");
        $select_video->execute([$get_id, $tutor_id]);
        if ($select_video->rowCount() > 0) {
        while($fetch_video= $select_video->fetch (PDO::FETCH_ASSOC))
        { $video_id = $fetch_video['id'];
        
        ?>
        <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="video_id" value="<?= $fetch_video['id']; ?>">
        <input type="hidden" name="old_thumb" value="<?= $fetch_video['thumb']; ?>">
        <input type="hidden" name="old_video" value="<?= $fetch_video['video']; ?>">
        <p>Update Status <span>*</span></p>
        <select name="status" class="box">
            <option value="<? $fetch_video['status'] ?>" selected ><?= $fetch_video['status'] ?></option>
            <option value="active">active</option>
            <option value="deactive">deactive</option>
        </select>
        <p>Update Video title <span>*</span></p>
        <input type="text" name="title" maxlength="150" required placeholder="Enter Playlist Title" value="<?= $fetch_video['title'] ?>" class="box" > 
        <p>Update Video description <span>*</span></p>
        <textarea name="description" id="" class="box" placeholder="Write Description" maxlength="1000" cols="30" rows="10"><?= $fetch_video['description'] ?></textarea>
        <p>Update Video Playlist <span>*</span></p>
        <select name="playlist" class="box">
            <option value="<?= $fetch_video['playlist_id'] ?>" selected disabled>---Select Playlist---</option>
            <?php
            $select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
            $select_playlists->execute([$tutor_id]);
            if ($select_playlists->rowCount() > 0) {
            while($fetch_playlist = $select_playlists->fetch(PDO::FETCH_ASSOC)){
            ?>
             <option value="<?= $fetch_playlist['id']; ?>"><?= $fetch_playlist['title']; ?></option>
                        <?php
                    }
                } else {
                    echo '<p class="empty">No playlist added yet!</p>';
                }
                ?>
            </select>
        <img src="../upload file/<?=$fetch_video['thumb']; ?>">
        <p>Update Thumbnail <span>*</span></p>
        <input type="file" name="image" accept="image/*"  class="box">
        <video src="../upload file/<?=$fetch_video['video']; ?>"  controls></video>
        <p>Update Video <span>*</span></p>
        <input type="file" name="video" accept="video/*"  class="box">
        
        <div class="flex-btn">
            <input type="submit" name="update" value="Update video" class="btn">
            <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">view content</a> 
            <input type="submit" name="delete" value="Delete Video" class="btn">
            </div>
                    
        </form>
        <?php
                }
            }else{
                echo '<div class="empty">
                <p style="margin-bottom:1.5rem;">No Video Added Yet!</p>
                <a href="addcontent.php" class="btn" style="margin-top:1.5rem;">Add Videos</a>
            </div>';
            }
            ?>
    </section>
    <?php include '../component/footer.php';?>

    <script src="../js/admin_script.js"></script>
</body>
</html>