<?php include "content/includes/init.php"; 
    if(logged_in()){
        $username=$_SESSION['username'];
    }else{
        set_msg("Please log-in and try again");
        redirect("index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <?php include "content/includes/header.php" ?>
    <body>
        <?php include "content/includes/nav.php" ?>

        <div class="container">
            <?php
                show_msg();
            ?>
            <h1 class="text-center"><?php echo $username ?>'s Content</h1>
            <?php
             
                    try{
                        $sql="SELECT u.username, g.name AS group_name, g.description AS group_descr, p.name  "; 
                        $sql.="AS page_name, p.description AS page_descr, p.url ";
                        $sql.="FROM users u JOIN user_group_link gu ON u.id=gu.user_id ";
                        $sql.="JOIN groups g ON gu.group_id=g.id "; 
                        $sql.="JOIN pages p ON g.id=p.group_id ";
                        $sql.="WHERE username= '{$username}' ";
                        $sql.="ORDER BY group_name";
                        $result=$pdo->query($sql);
                   
                        if($result->rowCount()>0){ //as result is also an object, we can use the rowCount method,
                                                //to check whether or not we have users registered in our users table
                            $prev_group=" ";
                            echo "<table class='table'>";
                            foreach($result as $row){
                                 if($prev_group != $row['group_name']){
                                    echo "<tr class='tbl-group-head'><td>{$row['group_name']}</td><td>{$row['group_descr']}</td></tr>"; 
                                 }
                                  echo "<tr><td></td><td><a href='content/{$row['url']}'>{$row['page_name']}</a></td><td>{$row['page_descr']}</td></tr>";
                                 $prev_group=$row['group_name'];
                            }
                            echo "</table>";
                            $row=return_field_data($pdo,"users","username",$username);
                            $user_id=$row['id'];
                            echo "<a class='btn btn-success text-center' href='content/admin_edit_user.php?id={$user_id}'>Edit Profile</a>";
                    }
                    else{
                        echo "<h4>No content available for '{$username}'</h4>.";
                    }
                }catch (PDOException $e){
                        echo "ERROR: ".$e->getMessage();
            }
        ?>
         </div> <!--Container-->
        
        <?php include "content/includes/footer.php" ?>
    </body>
</html>