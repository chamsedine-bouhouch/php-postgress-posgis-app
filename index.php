<?php include "content/includes/init.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <?php include "content/includes/header.php" ?>
    <body>
        <?php include "content/includes/nav.php" ?>

        <div class="container">
            <?php
                //  if(isset($_SESSION['message'])){
                //      echo "<p class='bg-success text-center'>{$_SESSION['message']}</p>"; 
                //      unset($_SESSION['message']);
                //  }
                show_msg();
            ?>
            <h1 class="text-center"> Home Page</h1>
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
        </div> <!--Container-->
        
        <?php include "content/includes/footer.php" ?>
    </body>
</html>