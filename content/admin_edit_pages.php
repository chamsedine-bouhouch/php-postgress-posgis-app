<?php 
    include("includes/init.php");

    if(logged_in()){
        $username=$_SESSION['username'];
        if(!verify_user_group($pdo, $username,"Admin")){
            set_msg("User '{$username}' does not have permission do view this page");
            redirect("../index.php");
        }
    }else{
        set_msg("Please log-in and try again");
        redirect("../index.php");
    }

    if(isset($_GET['id'])){
        $page_id=$_GET['id'];
        if(count_field_val($pdo, "pages","id",$page_id)>0){
            $row=return_field_data($pdo,"pages","id",$page_id);
            $name=$row['name'];
            $url=$row['url'];
            $group_id=$row['group_id'];
            $descr=$row['description'];

        }else{
             redirect("admin.php");
    }
    }else{
        redirect("admin.php");
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name=$_POST['name'];
        $url=$_POST['url'];
        $group_id=$_POST['group_id'];
        $descr=$_POST['description'];
        if(!isset($error)){
            try{
                $sql = "UPDATE pages SET name=:name, url=:url, group_id=:group_id, description=:descr WHERE id=:id";        
                $stmnt=$pdo->prepare($sql);
                $page_data=[':name'=>$name,':url'=>$url,':group_id'=>$group_id,':descr'=>$descr, ":id"=>$page_id];
                $stmnt->execute($page_data);
                redirect("admin.php?tab=pages");
             }catch(PDOException $e){
                echo "ERROR: ".$e->getMessage();
            }   
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php include "includes/header.php" ?>
    <body>
        <?php include "includes/nav.php" ?>

        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                <?php
                    show_msg();
                    if(isset($error)){
                        foreach($error as $msg){
                            echo "<p class='bg-danger text-center'>{$msg}</p>";
                        }
                    }
                ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-login">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="register-form" method="post" role="form" >
                                        <div class="form-group">
                                            <input type="text" name="name" id="name" tabindex="1" class="form-control" placeholder="Name" value="<?php echo $name ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="url" id="url" tabindex="1" class="form-control" placeholder="URL" value="<?php echo $url ?>">
                                        </div>
                                        <div class="form-group">
                                            <select type="text" name="group_id" id="group_id" tabindex="1" class="form-control" required>
                                                <?php
                                                    try{
                                                        $result=$pdo->query("SELECT id, name FROM groups ORDER BY name");
                                                        foreach($result as $row){
                                                            if($row['id']==$group_id){
                                                                $selected=" selected";
                                                            }else{
                                                                $selected= "";
                                                            }
                                                            echo "<option value= {$row['id']}{$selected}>{$row['name']}</option>";
                                                        }
                                                    }catch(PDOException $e){
                                                        echo "ERROR: ".$e->getMessage();
                                                    }
                                                
                                                
                                                ?>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="description" id="description" tabindex="7" class="form-control" 
                                                      placeholder="Description" required><?php echo $descr ?></textarea>
                                        </div>
                                          <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="update-submit" id="update-submit" tabindex="4" 
                                                           class="form-control btn btn-custom" value="update Now">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "includes/footer.php" ?>
    </body>
</html>