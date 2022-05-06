<?php
    include("includes/init.php");
    $result = $pdo->query("SELECT *, ST_AsGeoJSON(geom, 5) AS geojson FROM points_lumineux");
    // echo var_dump($result);
    // echo $result->rowCount();
    $features=[];
    foreach ($result AS $row){
        // echo var_dump($row)."<br>";
        unset($row['geom']);
        $geometry = $row['geojson']=json_decode($row['geojson']);
        unset($row['geojson']);
        $feature=["type"=>"Feature", "geometry"=>$geometry,"properties"=>$row];
        array_push($features, $feature);
        // $row['geojson']=json_decode($row['geojson']);
        // echo json_encode($row)."<br><br>";

    }
    $featureCollection=["type"=>"FeatureCollection","features"=>$features];
    echo json_encode($featureCollection);

?>