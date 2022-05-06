<?php include "includes/init.php"; ?>

<?php 
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $fname=$_POST['firstname'];
        $lname=$_POST['lastname'];
        $uname=$_POST['username'];
        $email=$_POST['email'];
        $email_conf=$_POST['email_confirm'];
        $pword=$_POST['password'];
        $pword_conf=$_POST['password_confirm'];
        $comments=$_POST['comments'];

        if(strlen($lname)<3){
            $error[] = "Last name must be at least 3 characters long";
        }
        if(strlen($uname)<6){
            $error[] = "username must be at least 3 characters long";
        }
        if(strlen($pword)<6){
            $error[] = "Passwords must be at least 3 characters long";
        }

        if($pword != $pword_conf){
            error[]="Passwords do not match";
        }
        if($email != $email_conf){
            error[]="Passwords do not match";
        }
        if(!isset($error)){
            try{
                // $sql = "INSERT INTO users (firstname, lastname, username, email, password, comments, validationcode, active, joined, last_login) 
                //         VALUES ('{$_POST['firstname']}','{$_POST['lastname']}','{$_POST['username']}','{$_POST['email']}',
                //                 '{$_POST['password']}','{$_POST['comments']}',test, 0, current_date, current_date)"; 
                                    //Current_date is a SQL function that returns the current date.
                $sql = "INSERT INTO users (firstname, lastname, username, email, password, comments, validationcode, active, joined, last_login) 
                        VALUES (:firstname, :lastname, :username, :email, :password, :comments, 'test', 0, current_date, current_date)"; 
                // echo $sql;
                $stmnt=$pdo->prepare($sql);
                $user_data=[':firstname'=>$fname,':lastname'=>$lname,
                            ':username'=>$uname,':password'=>$pword,
                            ':email'=>$email,
                            ':comments'=>$comments];
                $stmnt->execute($user_data);
                // echo "USER ENTERED INTO DATABASE";
            }catch(PDOException $e){
                echo "ERROR: ".$e->getMessage();
            }
            // foreach($_POST as $key=>$val){
            //     echo "Key: {$key} - Value: {$val} <br>";
            // }
        }


    }else{
        // echo "NO POST DATA INCLUDED";
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
                                            <input type="text" name="firstname" id="firstname" tabindex="1" class="form-control" placeholder="First Name" value="" required >
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="lastname" id="lastname" tabindex="2" class="form-control" placeholder="Last Name" value="" required >
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="username" id="username" tabindex="3" class="form-control" placeholder="Username" value="" required >
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="register_email" tabindex="4" class="form-control" placeholder="Email Address" value="" required >
                                        </div> 
                                        <div class="form-group">
                                            <input type="email" name="email_confirm" id="email_confirm" tabindex="4" class="form-control" placeholder="Email Address" value="" required >
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" tabindex="5" class="form-control" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_confirm" id="password_confirm" tabindex="6" class="form-control" placeholder="Confirm Password" required>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="comments" id="comments" tabindex="7" class="form-control" placeholder="Comments" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-custom" value="Register Now">
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