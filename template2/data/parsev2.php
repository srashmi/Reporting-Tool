<?php

class transform{


public function readGranularData($temp_config){

$file = "/Library/WebServer/Documents/php_templates/template2/data/granular.txt";
$json = json_decode(file_get_contents($file), true);

for ($i = 0; $i < sizeof($json["dimensions"][0]["columns"]); $i=$i+5) {
    
    $original_timestamp = $json["dimensions"][0]["columns"]["$i"]["start"];
    $timestamp          = (int) substr($original_timestamp, 0, -3);
    
array_push($temp_config['chart']['xAxis']['categories'],date('m', $timestamp));
array_push($temp_config['chart']['series'][0]['data'], $json["dimensions"][0]["values"][$i]);    
}

$res = $this->writeJSONData($temp_config);

//echo "<p>panel - ",	$temp_config['admin']['panel'],"</p><script type=\"text/javascript\">makeGraph(",$temp_config,")</script>";
return $res;
}

public function writeJSONData($temp_config){
$tempLabel=$temp_config['chart']['xAxis']['categories'];

foreach($temp_config['chart']['xAxis']['categories'] as $label){
$tempLabel = $tempLabel.$label.",";

}

$tempDatasets = $temp_config['chart']['series'][0]['data'];
foreach($temp_config['chart']['series'][0]['data'] as $ds){
$tempDatasets = $tempDatasets.$ds.",";

}

$data = json_encode($temp_config);
$file = '/Library/WebServer/Documents/php_templates/template2/data/data3.txt';
file_put_contents($file, $data);
return $data;
 }

}

//echo "<script type=\"text/javascript\">makeGraph(",$config,")</script>";

?>
