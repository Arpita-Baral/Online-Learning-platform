<?php
    include '../component/connect.php';
    if(isset($_COOKIE['tutor_id'])){
        $tutor_id=$_COOKIE['tutor_id'];
    }else{
        $tutor_id='';
        header('location: login.php');
    }
    if(isset($_POST['submit'])){
        $id=unique_id();
        $title=$_POST['title'];
        $title=filter_var($title,FILTER_SANITIZE_STRING);
        $description=$_POST['description'];
        $description=filter_var($description,FILTER_SANITIZE_STRING);
        $status=$_POST['status'];
        $status=filter_var($status,FILTER_SANITIZE_STRING);

        $playlist=$_POST['playlist'];
        $playlist=filter_var($playlist,FILTER_SANITIZE_STRING);

        $image=$_FILES['image']['name'];
        $image=filter_var($image,FILTER_SANITIZE_STRING);
        $ext=pathinfo($image,PATHINFO_EXTENSION);
        $rename= unique_id().'.'.$ext;
        $image_size=$_FILES['image']['size'];
        $image_tmp_name=$_FILES['image']['tmp_name'];
        $image_folder='../upload file/'.$rename;

        $video=$_FILES['video']['name'];
        $video=filter_var($video,FILTER_SANITIZE_STRING);
        $video_ext=pathinfo($video,PATHINFO_EXTENSION);
        $rename_video=unique_id().'.'.$video_ext;
        $video_tmp_name=$_FILES['video']['tmp_name'];
        $video_folder='../upload file/'.$rename_video;

       if($image_size>2000000){
            $message[]='Image size is too large';
       }else{
        $add_playlist = $conn->prepare("INSERT INTO `content` (id, tutor_id, playlist_id, title, description, video, thumb, status) VALUES (?,?,?,?,?,?,?,?)");
        $add_playlist->execute([$id, $tutor_id, $playlist, $title, $description, $rename_video, $rename, $status]);
        move_uploaded_file($image_tmp_name, $image_folder);
        move_uploaded_file($video_tmp_name, $video_folder);
        $message[] = 'new course uploaded';
       }
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
        <form action="" method="post" enctype="multipart/form-data">
        
        <p>Playlist status <span>*</span></p>
        <select name="status" class="box">
            <option value="" selected disabled>--select--</option>
            <option value="active">active</option>
            <option value="deactive">deactive</option>
        </select>
        <p>Video title <span>*</span></p>
        <input type="text" name="title" maxlength="150" required placeholder="Enter Playlist Title" class="box">
        <p>Video description <span>*</span></p>
        <textarea name="description" id="" class="box" placeholder="Write Description" maxlength="1000" cols="30" rows="10"></textarea>
        <p>Video Playlist <span>*</span></p>
        <select name="playlist" class="box">
            <option value="" selected disabled>---Select--</option>
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
        
        <p>Select Thumbnail <span>*</span></p>
        <input type="file" name="image" accept="image/*" required class="box">
        <p>Select Video <span>*</span></p>
        <input type="file" name="video" accept="video/*" required class="box">
        <input type="submit" value="Upload Video" name="submit"class="btn">
        
        </form>
    </section>
    <?php include '../component/footer.php';?>

    <script src="../js/admin_script.js"></script>
</body>
</html>