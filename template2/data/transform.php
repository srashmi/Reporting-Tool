<?php

//$newObject = new transform(); 
//$config = $newObject->readGranularData($temp_config); 

class transform{

$json = "Globvar";

public function findFile($temp_config){
echo "findfile";
// Logic to decide which file to read from
global $json;
echo "Start: ",$temp_config['range']['start'];
echo nl2br("\n\n");
echo "End: ",$temp_config['range']['end'];
echo "Read file: ",strtotime($temp_config['range']['start'])," to ", strtotime($temp_config['range']['start']);

$file = "/Library/WebServer/Documents/php_templates/template2/data/granular/1.txt";
$json = json_decode(file_get_contents($file), true);


//$res = $this->writeJSONData($temp_config);

//return $res;
}

public function writeJSONData($temp_config){
global $json;
for ($i = 0; $i < sizeof($json["dimensions"][0]["columns"]); $i=$i+5) {
    
    $original_timestamp = $json["dimensions"][0]["columns"]["$i"]["start"];
    $timestamp          = (int) substr($original_timestamp, 0, -3);
    array_push($temp_config['chart']['xAxis']['categories'],date('m', $timestamp));
	array_push($temp_config['chart']['series'][0]['data'], $json["dimensions"][0]["values"][$i]);    
}

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
