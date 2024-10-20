<?php
    include '../component/connect.php';
    if(isset($_COOKIE['tutor_id'])){
        $tutor_id=$_COOKIE['tutor_id'];
    }else{
        $tutor_id='';
        header('location: login.php');
    }if (isset($_POST['delete'])) {
        $delete_id = $_POST['playlist_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
        $verify_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? AND tutor_id = ? LIMIT 1");
        $verify_playlist->execute([$delete_id, $tutor_id]);
        
        if ($verify_playlist->rowCount() > 0) {
        $delete_plalist_thumb = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? LIMIT 1");
        $delete_plalist_thumb->execute([$delete_id]);
        $fetch_thumb = $delete_plalist_thumb->fetch (PDO::FETCH_ASSOC); 
        $file_path = '../upload file/'.$fetch_thumb['thumb'];

        // Check if the file exists before attempting to delete it
        if (file_exists($file_path)) {
            unlink($file_path); // Delete the file
        } else {
            $message[] = 'File does not exist, cannot delete thumbnail';
        }
        $delete_bookmark = $conn->prepare("DELETE FROM `bookmark` WHERE playlist_id = ?"); 
        $delete_bookmark->execute([$delete_id]);
        $delete_playlist = $conn->prepare("DELETE FROM `playlist` WHERE id = ?"); 
        $delete_playlist->execute([$delete_id]);
        $message[]='playlist deleted';
    }else{
        $message[]= 'Playlist already deleted';
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
    <section class="playlist">
        <h1 class="heading">Added Playlist</h1>
        <div class="box-container">
        <div class="add">
             <a href="addplaylist.php"><i class="bx bx-plus"></i></a>
        </div>
        <?php
        $select_playlists=$conn->prepare('SELECT * FROM `playlist` WHERE tutor_id=? ORDER BY date DESC');
        $select_playlists->execute([$tutor_id]);
        if($select_playlists->rowCount()> 0){
            while($fetch_playlist=$select_playlists->fetch(PDO::FETCH_ASSOC)) {
                $playlist_id=$fetch_playlist['id'];
                $count_videos=$conn->prepare('SELECT * FROM `content` WHERE playlist_id=?');
                $count_videos->execute([$playlist_id]);
                $total_videos=$count_videos->rowCount();
                ?>
        <div class="box">
        <div class="flex">
         <div><i class="bx bx-dots-vertical-rounded" style="<?php 
             if($fetch_playlist['status'] == 'active') 
             { echo "color:limegreen ";}
             else{ echo "color:red";} ?>"></i><span style="<?php 
             if($fetch_playlist['status'] == 'active') { echo "color:limegreen ";}
             else{ echo "color:red";} ?>">
             <?= $fetch_playlist['status']; ?></span> 
            </div>
            <div> <i class="bx bx-calender"></i><span><?= $fetch_playlist['date']; ?></span> </div>
        </div>
            <div class="thumb">
            <span> <?= $total_videos; ?></span>
            <img src="../upload file/<?= $fetch_playlist['thumb']; ?>">
            </div>
            <h3 class="title"><?= $fetch_playlist['title']; ?></h3>
            <p class="description"> <?= $fetch_playlist['description']; ?></p> 
            <form action="" method="post" class="flex-btn">
            <input type="hidden" name="playlist_id" value="<?= $playlist_id; ?>">
            <a href="update_playlist.php?get_id=<?= $playlist_id; ?>"class="btn">update</a>
            <input type="submit" name="delete" value="delete" class="btn" onclick="return confirm('delete this playlist');">
            <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">view playlist</a>
            </form>
                
            </div>
        

           <?php
            }

        }else{
            echo' <p class="empty">No playlist added yet</p>';
        }
        ?></div>
        
    </section>
    <?php include '../component/footer.php';?>

    <script src="../js/admin_script.js"></script>
</body>
</html>