<?php
if (isset($message)) {
foreach($message as $msg)
{ echo'
<div class="message">
<span>'.$msg. '</span>
<i class="bx bx-x" onclick="this.parentElement.remove();"></i> 
</div>';
}}?>
<header class="header">
<section class="flex">
<a href="home.php"> <img src="/Learn/Learn/logo.png" width="130px"> </a> <nav class="navbar">
<a href="index.php"><span>home</span></a>
<a href="about.php"><span>about us</span></a> <a href="courses.php"><span>courses</span></a> <a href="admin/login.php"><span>teachers</span></a> <a href="contact.php"><span>contact us</span></a> </nav>



<div class="icons">
            <div id="menu-btn" class="bx bx-list-plus"></div>
            <!-- <div id="search-btn" class="bx bx-search"></div> -->
            <div id="user-btn" class="bx bx-user"></div>
          </div>
          <div class="profile">
            <?php
            $select_profile=$conn->prepare("select * from `user` where id=?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount()> 0){
                $fetch_profile =$select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <!-- <img src="../upload file/<?=$fetch_profile['image']; ?>"> -->
                <h3><?=$fetch_profile['name']; ?></h3>
                <span>Student</span><br>
                <div id="flex-btn">
                    <a href="profile.php" class="btn">View Profile</a>
                    <a href="component/logout.php" onclick="return confirm('log out from this website?');" class="btn">Logout</a>
                </div>
            <?php
            }else{
            ?>
            <h3>Please Login or Register</h3>
            <div id="flex-btn">
                    <a href="login.php" class="btn">Login</a>
                    <a href="register.php" class="btn">Register</a>
                    
                </div>
          <?php } ?>
          </div>
</section></header>