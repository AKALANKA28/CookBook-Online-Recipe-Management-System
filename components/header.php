

<nav class="nav">
     <a href="index.php" class="logo">Cookbook.</a>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="recipes.php">Recipes</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="#contact_us">Contact Us</a></li>
    </ul>

    <?php
    if ($user_id != '') {
        $fetch_profile = null; // Initialize $fetch_profile

        $select_profile = "SELECT * FROM `users` WHERE id = ? LIMIT 1";
        $stmt = $conn->prepare($select_profile);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $fetch_profile = $result->fetch_assoc();
        }

        if ($fetch_profile) {
            if ($fetch_profile['image'] != '') { ?>
                <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="" class="user-pic" id="user-btn">
            <?php } ?>
            <div class="header">
                <div class="flex">
                    <div class="profile">
                        <?php if ($fetch_profile['image'] != '') { ?>
                            <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="" class="uimage">
                        <?php } ?>

                        <p><?= $fetch_profile['name']; ?></p>
                        <a href="update.php" class="ubtn">update profile</a>
                        <a href="components/logout.php" class="delete-btn" onclick="return confirm('logout from this website?');">logout</a>
                    </div>
                <?php
                }
               } else {
                ?>
                
                    <a href="user2_login.php" class="login">login as user</a>
                    <a href="user_login.php" class="login">login as Chef</a>
               
            </div>
        </div>
    <?php
    }
    ?>
</nav>