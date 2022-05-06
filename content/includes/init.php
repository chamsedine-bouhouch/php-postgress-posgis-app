<?php
    ob_start();
    session_start();
    
    //  *************** For PostgreSQL
    $dsn = "pgsql:host=localhost;dbname=tadaeem;port=5432";
    $pass=123456;
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false
    ];
    $pdo = new PDO($dsn, 'postgres', $pass, $opt);
    //  *************** For MySQL
    //    $dsn = "mysql:host=localhost;dbname=login_course;port=3306;charset=utf8";
    //    $user='root';
    //    $pass=null;
    //    $opt = [
    //        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    //        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //        PDO::ATTR_EMULATE_PREPARES   => false
    //    ];
    //    $pdo = new PDO($dsn, $user, $pass, $opt);
    
    $root_directory = "CMS";
    $from_email = "admin@imgenv.com";
    $reply_email = "admin@imgenv.com";
    include "php_functions.php";
?>
