<?php
    include("../includes/init.php");

    if (isset($_POST['tbl'])) {
        $table = $_POST['tbl'];
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
           
    
            try {
                $result = $pdo->query('SELECT id, surveyor, date , result, createdby  FROM '.$table.' WHERE id='.$id.' ORDER BY date DESC, id DESC');
                $returnTable="<h2 class='text-center'>Survey Results of ID {$id}</h2>";
                $returnTable.="<table class='table table-hover'>";
                $returnTable.="<tr class='tblHeader'><th>Surveyor</th><th>SurveyDate</th><th>Result</th><th>Created By</th><th></th><th></th></tr>";
                foreach($result AS $row) {
                    $returnTable.="<tr> 
                                    <td>{$row['surveyor']}</td>
                                    <td>{$row['date']}</td>
                                    <td>{$row['result']}</td>
                                    <td>{$row['createdby']}</td>
                                    <td><button class='btn btn-warning btn-xs btnEditSurvey' data-id= '{$row['id']}'>Edit</button></td>
                                    <td><button class='btn btn-danger btn-xs btnDeleteSurvey' data-id='{$row['id']}'>Delete</button></td>
                                </tr>";
                }
                $returnTable.="</table>";
                echo $returnTable;
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