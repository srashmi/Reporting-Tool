<?php
//fetchFromJenkins();
function fetchFromJenkins(){

//include('pathconfig.php');
$granData = file_get_contents($jenkins_api);
//echo $granData;
file_put_contents($jenkins_data, $granData);
}
?>
