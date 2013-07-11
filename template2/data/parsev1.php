<?php
//$file = fopen("blah.txt", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
//while(!feof($file))
  //{
  //echo fgets($file). "<br>";
  //}
//fclose($file);
echo "bleh";
$labels = array();
$dataSets = array();
class transform{

public function readGranularData(){
global $labels;
$dataSets = array();
echo "readGranularData2--";
$file = "granular.txt";
$json = json_decode(file_get_contents($file), true);
//var_dump($json);

echo $json["dimensions"][0]["columns"][0]["end"];
echo nl2br("\nSuccess only \n");

for ($i = 0; $i < sizeof($json["dimensions"][0]["columns"]); $i=$i+5) {
    echo nl2br("i = ");
    echo $i;
    echo nl2br(";(x,y) = ");
    $original_timestamp = $json["dimensions"][0]["columns"]["$i"]["start"];
    $timestamp          = (int) substr($original_timestamp, 0, -3);
    echo date('m', $timestamp), ", ";
    echo $json["dimensions"][0]["values"][$i];
array_push($labels,date('m', $timestamp));
array_push($dataSets, $json["dimensions"][0]["values"][$i]);    
echo nl2br("\n");
    echo nl2br("\n");
}
}

public function writeJSONData(){
global $labels;
echo "second func works??....";
echo sizeof($labels);
$tempLabel="labels: [";
foreach($labels as $label){
$tempLabel = $tempLabel.$label.",";
echo $label,",";
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

$newObject = new transform(); 

$newObject->readGranularData(); 
$newObject->writeJSONData(); 
?>
