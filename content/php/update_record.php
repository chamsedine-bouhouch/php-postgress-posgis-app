<?php
    include("../includes/init.php");

    $username=$_SESSION['username'];
    if (isset($_POST['tbl'])) {
        $table = $_POST['tbl'];
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            unset($_POST['tbl']);
            unset($_POST['id']);
            try {
                $sets="";
                foreach($_POST as $key=>$val){
                    if ($key=="geojson"){
                        $sets.="geom=ST_SetSRID(ST_GeomFromGeoJSON(:geojson), 4326), ";
                    }else{
                        $sets.="{$key}=:{$key}, ";
                    }
                }
                $sqlQuery="UPDATE {$table} SET {$sets} modified=current_date, modifiedby='{$username}' WHERE id={$id}";
                // $sqlQuery="UPDATE {$table} SET {$sets}modified=current_date WHERE id={$id}";
                $result = $pdo->prepare($sqlQuery);
                $result->execute($_POST);
                // echo "ERROR: ".$sqlQuery;
                echo $sqlQuery;
            } catch(PDOException $e) {
                echo "ERROR: ".$e->getMessage();
            }
        } else {
           echo "ERRORS: ID not included in survey request";
        }
    } 
        else {
            echo "ERROR: No table parameter included with request";
        }
    

?>