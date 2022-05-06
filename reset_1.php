<?php 
     include "content/includes/init.php";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $username=$_POST['username'];
        if(count_field_val($pdo, "users","username",$username)>0){
            $row=return_field_data($pdo,"users","username",$username);
            $body="Please go to <a href='http://{$_SERVER['SERVER_NAME']}/{$root_directory}/reset_2.php?user={$username}&code={$row['validationcode']}'>Reset Password</a><br> in order to reset your password";
            send_mail($row['email'],"Reset Password",$body,$from_email,$reply_email);    
        }else{
            set_msg("User '{$username}' was not found in the database");
        }
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
                                    <h2 class="text-center">Reset Password</h2>
								    <form id="login-form"  method="post" role="form" style="display: block;">
									    <div class="form-group">
										    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="" required>
									    </div>
									    
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="reset-submit" id="reset-submit" tabindex="4" class="form-control btn btn-custom" value="Reset Password">
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