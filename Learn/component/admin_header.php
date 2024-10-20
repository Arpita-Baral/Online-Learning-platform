<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
            <div class="message">
                <span>' . $msg . '</span>
                <i class="bx bx-x" onclick="this.parentElement.remove();"></i>
            </div>';
    }
}

?>
<header class="header">
    <section class="flex">
        <a href="dashboard.php"> <img src="/Learn/Learn/logo.png" width="130px"></a>
        <form action="search_page.php" method="post" class="search-form">
           <input type="text"name="search"placeholder="Search here.." required maxlength="100 ">
           <button type="submit" class="bx bxs-search" name="search-btn"></button>
        </form>
        <div class="icons">
            <div id="menu-btn" class="bx bx-list-plus"></div>
            <div id="search-btn" class="bx bxs-search"></div>
            <div id="user-btn" class="bx bx-user"></div>
          </div>
          <div class="profile">
            <?php
            $select_profile=$conn->prepare("select * from `tutors` where id=?");
            $select_profile->execute([$tutor_id]);
            if($select_profile->rowCount()> 0){
                $fetch_profile =$select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <img src="../upload file/<?=$fetch_profile['image'];?>">
                <h3><?=$fetch_profile['name']; ?></h3>
                <span><?=$fetch_profile['profession']; ?></span><br>
                <div id="flex-btn">
                    <a href="profile.php" class="btn">View Profile</a>
                    <a href="logout.php" onclick="return confirm('log out from this website?');" class="btn">Logout</a>
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
    </section>
</header>
<div class="side-bar">
    <div class="profile">
        <?php 
        $select_profile=$conn->prepare("select * from `tutors` where id=?");
        $select_profile->execute([$tutor_id]);
        if($select_profile->rowCount()> 0){
            $fetch_profile =$select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="../upload file/<?=$fetch_profile['image'];?>">
            <h3><?=$fetch_profile['name']; ?></h3>
            <p><?=$fetch_profile['profession']; ?></p>
            <a href="profile.php" class="btn">View Profile</a>
         <?php }else{ ?>
            <h3>Please Login or Register</h3>
            <div id="flex-btn">
                    <a href="login.php" class="btn">Login</a>
                    <a href="register.php" class="btn">Register</a>
                    
                </div>
            <?php } ?>
    </div>
    <nav class="navbar">
        <a href="dashboard.php"><i class="bx bxs-home-heart"></i><span>Home</span></a>
        <a href="playlists.php"><i class="bx bxs-receipt"></i><span>playlist</span></a>
        <a href="contents.php"><i class="bx bxs-graduation"></i><span>contents</span></a>
        <a href="comments.php"><i class="bx bxs-home-heart"></i><span>Comments</span></a>
        <a href="logout.php" onclick="return confirm('Log out from website?')"><i class="bx bx-hlog-in-cicle"></i><span>Logout</span></a>
    </nav>
</div>
