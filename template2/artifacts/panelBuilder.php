<?php include('..\data\variables.php');

function buildPanel($config) {

$data_source = json_decode($config);

$data_source_panelid = $data_source->admin->panel;
//echo "panel=",$data_source_panelid;
echo "<section id=\"panel",$data_source_panelid,"\">

<h3>",$title,"</h3>
<h4>",$subtitle,"</h4>


<div id=\"graph",$data_source_panelid,"\"></div>



</section>";
// $file = '../data/variables.txt';
// $dataObject = "{panelid: \"graph".$data_source_panelid."\"}";
// file_put_contents($file, $dataObject);
//return $config;
}

?>