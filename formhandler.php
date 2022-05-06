<?php
    if (isset($_GET['username'])){
        $username=$_GET['username'];
    }if(isset($_GET['password'])){
        $password=$_GET['password'];
    }
    echo "SELECT username, password from users WHERE username = '{$username}' AND password = '{$password}'";

?>