<?php 
    $data = ["id"=>1, "status"=>"ACTIVE NEST","species"=>"Red-Tailed hawk"];
    $feature = ["type"=>"nest","data"=>$data];
    echo json_encode($feature);

?>