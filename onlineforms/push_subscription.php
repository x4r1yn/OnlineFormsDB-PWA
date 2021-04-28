<?php

ini_set('display_errors',1);

$sub = json_decode(file_get_contents('php://input'), true);

$file = "push_subscription.json";
$flag = false;

$inp = file_get_contents($file);
$arr_data = json_decode($inp,true);

if(is_array($arr_data)){
	for($i = count($arr_data)-1; $i >= 0; $i--){
	    if($arr_data[$i]["authToken"] == $sub['authToken']){
	            $flag = true;
	    }
	}
}

if(!$flag){
	$arr_data[] = $sub;
    $json_data = json_encode($arr_data);
    file_put_contents($file, $json_data);
}

var_dump($sub);

?>