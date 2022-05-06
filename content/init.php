<?php
    ob_start();
    session_start();
    //  ****************** For PostgreSQL
    $dsn = "pgsql:host=localhost;dbname=tadaeem;port=5432";
    $pass=123456;
    $opt=[
        PDO::ATTR_ERRMODE            =>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   =>false
    ];
    $pdo=new PDO($dsn, 'postgres','postgres', $opt);







?>