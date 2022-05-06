<?php
        include "../includes/init.php";
        if (isset($_POST['id'])) {
            $id=$_POST['id'];
        } else {
            $id=1;
        }
        if ($id=="geojson") {
            $geojson=$_POST['geojson'];
        }
        try {
            if ($id=="geojson") {
                $sqlQuery="UPDATE {$table} SET {$sets}modified=current_date WHERE id={$id}";
                $result = $pdo->prepare($sqlQuery);
                $result->execute($_POST);
                // echo "ERROR: ".$sqlQuery;
                echo $sqlQuery;
            } else {
                $sets.="{$id}=:{$id}, ";

                $strQuery = 'SELECT Round(ST_Distance(geom::geography, geom::geography)) as dist, id as ID, section as Section, depart as DEPART, type as Type 
                             FROM reseaux ORDER BY dist';
                $result = $pdo->query($strQuery);
                $returnTable="<table class='table table-hover'>";
                $returnTable.="<tr class='tblHeader'><th>ID</th><th>ID</th><th>Distance</th><th>Section</th><th>Depart</th><th>Type</th></tr>";
                foreach($result AS $row) {
                    $returnTable.="<tr><td>BUOWL</td><td>{$row['id']}</td><td>{$row['dist']}</td><td>{$row['section']}</td><td>{$row['depart']}</td><td>{$row['type']}</td></tr>";
                }
            }
        } catch(PDOException $e) {
            echo "ERROR: ".$e->getMessage();
        }
?>