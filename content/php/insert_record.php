<?php
    include "../includes/init.php";
    $username=$_SESSION['username'];
    if(isset($_POST['tbl'])){
        $table=$_POST['tbl'];
        unset($_POST['tbl']);
        $dsn="pgsql:host=localhost;dbname=tadaeem;port = 5432";

        try{
            $keys="";
            $vals="";
            foreach($_POST as $key=>$val){
                if($key=="geojson"){
                    $keys.="geom, ";
                    $vals.="ST_SetSRID(ST_GeomFromGeoJSON(:geojson), 4326), ";

                }else{
                    $keys.="{$key}, ";
                    $vals.=":{$key}, ";
                }
            }
            $sqlQuery="INSERT INTO {$table} ({$keys}created, modified, modifiedby) VALUES ({$vals}current_date,current_date,'{$username}')";
            $result=$pdo->prepare($sqlQuery);
            $result->execute($_POST);
            echo $sqlQuery;
        }catch(PDOException $e){
            echo "ERROR: ".$e->getMessage();
        }
    }

//05:00





?>