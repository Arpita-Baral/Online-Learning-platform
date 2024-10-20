<?php
    include '../component/connect.php';
    if(isset($_COOKIE['tutor_id'])){
        $tutor_id=$_COOKIE['tutor_id'];
    }else{
        $tutor_id='';
        header('location:login.php');
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
    $message[]="Playlist Deleted";
} 
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
    <section class="contents">
    <h1 class="heading">Content</h1>
    <div class="box-container">
    <?php
        if (isset($_POST['search']) || isset($_POST['search_btn'])) {
            $search = $_POST['search'];
            // Properly using parameterized query for LIKE clause
            $select_videos = $conn->prepare("SELECT * FROM `content` WHERE title LIKE ? AND tutor_id = ? ORDER BY date DESC");
            $select_videos->execute(['%' . $search . '%', $tutor_id]);

            if ($select_videos->rowCount() > 0) {
                while ($fetch_videos = $select_videos->fetch(PDO::FETCH_ASSOC)) {
                    $video_id = $fetch_videos['id'];
    ?>
            <div class="box">
                <?php
                    // Set color based on status
                    $color = ($fetch_videos['status'] == 'active') ? 'limegreen' : 'red';
                ?>
                <div class="flex">
                    <div>
                        <i class="bx bx-dots-vertical-rounded" style="color:<?= $color; ?>"></i>
                        <span style="color:<?= $color; ?>"><?= $fetch_videos['status']; ?></span>
                    </div>
                </div>
                <div>
                    <i class="bx bxs-calendar-alt"></i>
                    <span><?= $fetch_videos['date']; ?></span>
                </div>
                
                <!-- Thumbnail image -->
                <img src="../upload file/<?= $fetch_videos['thumb']; ?>" class="thumb">

                <!-- Video Title -->
                <h3 class="title"><?= $fetch_videos['title']; ?></h3>

                <!-- Form for update and delete -->
                <form action="" method="post">
                    <input type="hidden" name="video_id" value="<?= $video_id; ?>">
                    <a href="update_content.php?get_id=<?= $video_id; ?>" class="btn">Update</a>
                    <input type="submit" name="delete_video" class="btn" value="Delete" onclick="return confirm('Are you sure you want to delete this?');">
                    <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">View Content</a>
                </form>
            </div>
    <?php
                }
            } else {
                echo '<p class="empty">No content found!</p>';
            }
        } else {
            echo '<p class="empty">Search something</p>';
        }
    ?>
    </div>
</section>

    <section class="playlist">
    <h1 class="heading">Playlist</h1>
    <div class="box-container">
    <?php
        if (isset($_POST['search']) or isset($_POST['search_btn'])) {
            $search = $_POST['search'];
            $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE title LIKE ? AND tutor_id = ? ORDER BY date DESC");
            $select_playlist->execute(['%' . $search . '%', $tutor_id]);

            if ($select_playlist->rowCount() > 0) {
                while ($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
                    $playlist_id = $fetch_playlist['id'];

                    // Fixed SQL query to select videos from playlist
                    $count_playlist = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
                    $count_playlist->execute([$playlist_id]); 
                    $total_playlists = $count_playlist->rowCount(); // Fixed variable name

    ?>
                <div class="box">
                <?php
                    // Set color based on status
                    $color = ($fetch_playlist['status'] == 'active') ? 'limegreen' : 'red';
                ?>
                <div class="flex">
                    <div>
                        <i class="bx bx-dots-vertical-rounded" style="color:<?= $color; ?>"></i>
                        <span style="color:<?= $color; ?>"><?= $fetch_playlist['status']; ?></span>
                    </div>
                </div>
                <div><i class="bx bxs-calendar-alt"></i><span><?= $fetch_playlist['date']; ?></span></div>
                
                <div class="thumb">
                    <!-- Display total videos in the playlist -->
                    <span><?= $total_playlists; ?></span>
                    <img src="../upload file/<?= $fetch_playlist['thumb']; ?>" class="thumb">
                </div>
                
                <h3 class="title"><?= $fetch_playlist['title']; ?></h3>
                <p class="description"><?= $fetch_playlist['description']; ?></p>

                <!-- Form for update and delete -->
                <form action="" method="post">
                    <input type="hidden" name="playlist_id" value="<?= $playlist_id; ?>">
                    <a href="update_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">update</a> 
                    <input type="submit" name="delete" class="btn" value="delete" onclick="return confirm('delete this');">
                    <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">view playlist</a>
                </form>
            </div>
    <?php
                }
            } else {
                echo '<p class="empty">No content found!</p>';
            }
        } else {
            echo '<p class="empty">Search something</p>';
        }
    ?>
    </div>
</section>

 
    <?php include '../component/footer.php';?>

    <script src="../js/admin_script.js"></script>
</body>
</html>