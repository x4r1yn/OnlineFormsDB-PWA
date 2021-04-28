<?php

$sub = json_decode(file_get_contents('php://input'), true);

$file = "push_subscription.json";

$inp = file_get_contents('push_subscription.json');
$arr_data = json_decode($inp,true);

var_dump($arr_data);

for($i = count($arr_data)-1; $i >= 0; $i--){
    if($arr_data[$i]["authToken"] == $sub['authToken']){
        unset($arr_data[$i]);
    }
}

file_put_contents($file, json_encode($arr_data));

?>