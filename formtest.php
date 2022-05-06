<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    if (isset($_POST['username'])){
        $username=$_POST['username'];
    }else{
        $username="";
    }
    if(isset($_POST['password'])){
        $password=$_POST['password'];
    }else{
        $password="";
    }
    echo "SELECT username, password from users WHERE username = '{$username}' AND password = '{$password}'";
    // foreach ($_SERVER as $key=>$val){
    //     echo " <br> {$key} = {$val}";
    // }
}
if(isset($_SESSION['username'])){
    $username=$_SESSION['username'];
}else if(isset($_COOKIE['username'])){
    $username=$_COOKIE['username'];
    $_SESSION['username']=$username;
}

else{
    redirect("index.php");
}
?>

<form action="" method="POST">
    Uername: <br>
    <input type="text" name='username'><br>
    Password: <br>
    <input type="password" name='password'><br>
    <input type="submit" name='submit' value='Submit'>

</form>