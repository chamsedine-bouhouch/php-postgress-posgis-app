<?php
if(isset($_POST['tbl'])){
    $table = $_POST['tbl'];
    if(isset($_POST['flds'])){
        $fields=$_POST['flds'];
    }else{
        $fields="*";
    }if(isset($_POST['where'])){
        $where = " WHERE ".$_POST['where'];
    }else{
        $where = " ";
    }if(isset($_POST['order'])){
        $order = " ORDER BY ".$_POST['order'];
    }else{
        $order = " ";
    }
    include("includes/init.php");
    $result = $pdo->query("SELECT *, ST_AsGeoJSON(geom, 5) AS geojson FROM {$table}");
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
}else{
    echo "ERROR: No table parameter included with request";

}
   
?>