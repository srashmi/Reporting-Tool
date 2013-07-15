<?php 

function buildPanel($config) {

$data_source = json_decode($config);
$data_source_panelid = $data_source->admin->panel;
//echo "panel=",$data_source_panelid;
echo "<section id=\"panel",$data_source_panelid,"\">
<div id=\"graph",$data_source_panelid,"\"></div>
</section>";
}

?>