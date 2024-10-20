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

        $image=$_FILES['image']['name'];
        $image=filter_var($image,FILTER_SANITIZE_STRING);
        $ext=pathinfo($image,PATHINFO_EXTENSION);
        $rename= unique_id().'.'.$ext;
        $image_size=$_FILES['image']['size'];
        $image_tmp_name=$_FILES['image']['tmp_name'];
        $image_folder='../upload file/'.$rename;
        $add_playlist=$conn ->prepare('INSERT INTO `playlist` (id,tutor_id,title,description,thumb,status) VALUES(?,?,?,?,?,?)');
        $add_playlist->execute([$id,$tutor_id,$title,$description,$rename,$status]);
        move_uploaded_file($image_tmp_name,$image_folder);
        $message[]='New Playlist Created';
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

        <form action="" method="post" enctype="multipart/form-data">
        <h1 class="heading">Create Playlist</h1>
        <p>playlist status <span>*</span></p>
        <select name="status" class="box">
            <option value="" selected disabled>--select--</option>
            <option value="active">active</option>
            <option value="deactive">deactive</option>
        </select>
        <p>playlist title <span>*</span></p>
        <input type="text" name="title" maxlength="150" required placeholder="Enter Playlist Title" class="box">
        <p>playlist description <span>*</span></p>
        <textarea name="description" id="" class="box" placeholder="Write Description" maxlength="1000" cols="30" rows="10"></textarea>
        <p>playlist thumbnail <span>*</span></p>
        <input type="file" name="image" accept="image/*" required class="box">
        <input type="submit" value="Create Playlist" name="submit"class="btn">
        
        </form>
    </section>
    <?php include '../component/footer.php';?>

    <script src="../js/admin_script.js"></script>
</body>
</html>