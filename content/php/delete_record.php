<?php
    include "../includes/init.php";
    if (isset($_POST['tbl'])) {
        $table = $_POST['tbl'];
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            
    
            try {
                $result = $pdo->query("DELETE FROM " .$table.  " WHERE id =".$id);
                echo "SUCCESS!!!!";
                
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