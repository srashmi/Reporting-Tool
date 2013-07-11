<?php
function fetchFromJenkins(){
//echo "fetching from jenkins..";
$homepage = file_get_contents('http://localhost:8080/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=awbQveOEOckFL*8Ex4*AbbZWff1SByGq');
//echo $homepage;

file_put_contents('../data/granular/jenkinsdata.txt', $homepage);
}
?>