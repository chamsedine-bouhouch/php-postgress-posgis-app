<?php
    include "content/includes/init.php";


    if(isset($_GET['user'])){
        $user=$_GET['user'];
        if(isset($_GET['code'])){
            $code=$_GET['code'];
            $db_code=get_validationcode($user, $pdo);
            if($code==$db_code){
                try{
                    $stmnt=$pdo->prepare("UPDATE users SET active=1 WHERE username =:username");
                    $stmnt->execute([':username'=>$user]);
                    set_msg("User activated, Please login to access your content" , "success");
                    redirect('index.php');
                }catch(PDOException $e){
                    echo "ERROR: {$e}";
                }
            }else{
                set_msg("Validation code does not match the database {$code} - {$db_code}");
                redirect('index.php');
            }
        }else{
            set_msg("No validation code included with activate request");
            redirect('index.php');
        }
    }else{
        set_msg("No user included with activate request");
        redirect('index.php');
    }


?>