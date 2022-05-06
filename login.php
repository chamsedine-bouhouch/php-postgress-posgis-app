<?php include "content/includes/init.php"; 

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $username=$_POST['username'];
    $password=$_POST['password'];
    if(isset($_POST['remember'])){
        $remember = "on";
    }else{
        $remember = "off";
    }
    // echo "Remember= {$_POST['remember']}";
    if (count_field_val($pdo, "users","username", $username)>0){
        $user_data=return_field_data($pdo, "users","username",$username);
        if($user_data['active']==1){
            var_dump($user_data);
            if(true){
                set_msg("Logged in successfully","success");
                update_login_date($pdo, $username);
                $_SESSION['username']=$username;
                if($remember == "on"){
                    setcookie("username", $username, time()+86400, "/", null, false, true);
                }
                redirect("mycontent.php");

            }else{
                set_msg("Password invalid");
            }
        }else{

            set_msg("User '{$username}' found but has not been activated","warning");
        }

    }else{
        set_msg("User '{$username}' does not exist");
    }
}else{
    $username="";
    $password="";
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php include "content/includes/header.php" ?>
    <body>
        <?php include "content/includes/nav.php" ?>
        <div class="container">
    	    <div class="row">
			    <div class="col-md-6 col-md-offset-3">
                <?php
                show_msg();
                ?>
				    <div class="panel panel-login">
					    <div class="panel-body">
						    <div class="row">
							    <div class="col-lg-12">
								    <form id="login-form"  method="post" role="form" style="display: block;">
									    <div class="form-group">
										    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="<?php echo $username ?>" required>
									    </div>
									    <div class="form-group">
										    <input type="password" name="password" id="login-
										password" tabindex="2" class="form-control" placeholder="Password" value="<?php echo $password ?>" required>
                                        </div>
                                        <div class="form-group text-center">
                                            <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                            <label for="remember">Stay logged in</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-custom" value="Log In">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center">
                                                        <a href="reset_1.php" tabindex="5" class="forgot-password">Forgot Password?</a>
                                                    </div>
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
        <?php include "content/includes/footer.php" ?>
    </body>
</html>