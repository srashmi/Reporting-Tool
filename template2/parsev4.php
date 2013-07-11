<?php
class transform{

//$labels = array();
//$dataSets = array();

//readGranularData();


public function readGranularData(){
$labels = array();
$dataSets = array();
echo "readGranularData2--";
// $file = "data/granular.txt";
// $json = json_decode(file_get_contents($file), true);
// //var_dump($json);
// 
// echo $json["dimensions"][0]["columns"][0]["end"];
// echo nl2br("\nSuccess only \n");
// 
// for ($i = 0; $i < sizeof($json["dimensions"][0]["columns"]); $i=$i+5) {
//     echo nl2br("i = ");
//     echo $i;
//     echo nl2br(";(x,y) = ");
//     $original_timestamp = $json["dimensions"][0]["columns"]["$i"]["start"];
//     $timestamp          = (int) substr($original_timestamp, 0, -3);
//     echo date('m', $timestamp), ", ";
//     echo $json["dimensions"][0]["values"][$i];
// array_push($labels,date('m', $timestamp));
// array_push($dataSets, $json["dimensions"][0]["values"][$i]);    
// echo nl2br("\n");
//     echo nl2br("\n");
// }
// testFunc($labels);
} 

public function testFunc($labels){
echo "second func works??....";
$dataSets = array();
$tempLabel="labels: [";
foreach($labels as $label){
$tempLabel = $tempLabel.$label.",";
//echo $label,",";
}
$tempLabel=$tempLabel."]";
echo "-----",$tempLabel;
$tempDatasets = "datasets: [
                                {
                                        \"fillColor\" : \"rgba(220,220,220,0.5)\",
                                        \"strokeColor\" : \"rgba(220,220,220,1)\",
                                        \"data\" : [";

foreach($dataSets as $ds){
$tempDatasets = $tempDatasets.$ds.",";
//echo $label,",";
}
$tempDatasets = $tempDatasets."]}]";
echo "-----" , $tempDatasets;

$dataObject = "{".$tempLabel.",".$tempDatasets."}";
echo nl2br("\nData Object:"); echo $dataObject;

//$data = json_encode($dataObject);
echo "*******",$data;
//$fh = fopen('data4.txt', 'a');
//fwrite($fh, $data);
$file = 'data4.txt';
file_put_contents($file, $dataObject);
//fclose($fh);
}
}

$foo= new transform();
$foo->readGranularData();
?>
