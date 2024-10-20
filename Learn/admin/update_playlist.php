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
    if (isset($_POST['update'])) {
        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $description= $_POST['description'];
        $description=filter_var($description,FILTER_SANITIZE_STRING);
        $status = $_POST['status'];
        $status = filter_var($status, FILTER_SANITIZE_STRING);
        $update_playlist = $conn->prepare("UPDATE `playlist` SET title = ?, description = ?, status
        = ? WHERE id = ?");
        $update_playlist->execute([$title, $description, $status, $get_id]);
        //update image
        $old_image=$_POST['old_image'];
        $old_image = filter_var($old_image, FILTER_SANITIZE_STRING);
        $image= $_FILES['image']['name'];
        $image=filter_var($image, FILTER_SANITIZE_STRING);
        $ext=pathinfo($image, PATHINFO_EXTENSION);
        $rename=unique_id().'.'.$ext;
        $image_size=$_FILES['image']['size'];
        $image_tmp_name=$_FILES['image']['tmp_name'];
        $image_folder= '../upload file/'.$rename;
        if(!empty($image)){
            if($image_size > 2000000){
                $message[]='Image size too Large';
            }
            else{
                $update_image= $conn->prepare("UPDATE `playlist` SET thumb =? WHERE id=?");
                $update_image->execute([$rename, $get_id]);
                move_uploaded_file($image_tmp_name, $image_folder);
                if($old_image!='' AND $old_image!=$rename){
                    unlink('../upload file/'.$old_image);
                }
    }
}
 $message[]= 'Playlist Updated';
 }
//delete 
if(isset($_POST['delete'])){
    $delete_id=$_POST['playlist_id'];
    $delete_id=filter_var($delete_id, FILTER_SANITIZE_STRING);
    $delete_plalist_thumb = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? LIMIT 1");
    $delete_plalist_thumb->execute([$delete_id]);
    $fetch_thumb = $delete_plalist_thumb->fetch (PDO::FETCH_ASSOC);
    //$file_path = '../upload file/'.$fetch_thumb['thumb'];
    unlink('../upload file/'.$fetch_thumb['thumb']);

    $delete_bookmark = $conn->prepare("DELETE FROM `bookmark` WHERE playlist_id = ?"); 
    $delete_bookmark->execute([$delete_id]);
    $delete_playlist = $conn->prepare("DELETE FROM `playlist` WHERE id = ?"); 
    $delete_playlist->execute([$delete_id]);
    header("Location: playlists.php");
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
    <section class="playlist-form">
    <h1 class="heading">Update Playlist</h1>
    <?php 
    $select_playlists=$conn->prepare('SELECT * FROM `playlist` WHERE  id=?');
    $select_playlists->execute([$get_id]);
    if($select_playlists->rowCount()> 0){
        while($fetch_playlists=$select_playlists->fetch(PDO::FETCH_ASSOC)){
            $playlist_id=$fetch_playlists['id'];
            $count_videos=$conn->prepare('SELECT * FROM `content` WHERE playlist_id=?');
            $count_videos->execute([$playlist_id]);
            $total_videos=$count_videos->rowCount();
    
    ?>
        <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="old_image" value="<?= $fetch_playlists['thumb'];?>">
        <input type="hidden" name="playlist_id" value="<?= $playlist_id; ?>">
        <p>playlist status <span>*</span></p>
        <select name="status" class="box">
            <option value="<?= $fetch_playlists['status'];?>" selected disabled></option>
            <option value="active">active</option>
            <option value="deactive">deactive</option>
        </select>
        <p>playlist title <span>*</span></p>
        <input type="text" name="title" maxlength="150" required placeholder="Enter Playlist Title" value="<?= $fetch_playlists['title'];?>" class="box">
        <p>playlist description <span>*</span></p>
        <textarea name="description" id="" class="box" placeholder="Write Description" maxlength="3000" cols="30" rows="10"><?= $fetch_playlists['description'];?></textarea>
        <p>playlist thumbnail <span>*</span></p>
        <div class="thumb">
            <span><?= $total_videos;?></span>
            
            <img src="../upload file/<?= $fetch_playlists['thumb']; ?>">

        </div>
        <input type="file" name="image" accept="image/*"  class="box">
        
        <div class="flex-btn">
        <input type="submit" value="Update Playlist" name="update"class="btn">
        <input type="submit" value="Delete Playlist" name="delete"class="btn" onclick="return confirm('Delete this Playlist');">
        <a href="view_playlist.php?get_id=<?= $playlist_id; ?>"class="btn">View Playlist</a>
        </div>
        
        </form>
        <?php 
        }
    }else{
        echo '<p class="empty">No playlist added yet</p>';
    }
    ?>
    </section>
    <?php include '../component/footer.php';?>

    <script src="../js/admin_script.js"></script>
</body>
</html>