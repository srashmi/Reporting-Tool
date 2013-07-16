<?php
//Base path
$base = "/Library/WebServer/Documents/gitdocs/Reporting-Tool";
// Artifact files
$collector = $base."/artifacts/collectors/collector.php";
$dashboard_frame = $base."/artifacts/dashboardFrame.php";
$jenkins_transform = $base."/artifacts/transformation/jenkins-transform.php";
$jenkins_getter = $base."/artifacts/collectors/jenkinsGetter.php";
$panel_builder = $base."/artifacts/ui/panelBuilder.php";
$transform = $base."/artifacts/transformation/transform.php";
$render_graph = "\Library\WebServer\Documents\gitdocs\Reporting-Tool\artifacts\ui\\renderGraph.js";
$highcharts = "\Library\WebServer\Documents\gitdocs\Reporting-Tool\artifacts\ui\js\highcharts.js";
$exportingjs = "\Library\WebServer\Documents\gitdocs\Reporting-Tool\artifacts\ui\js\modules\exporting.js";
// Data files
$jenkins_data = $base."/data/granular/jenkinsdata.txt";

// Styling files
$style = $base."/style/style.css";

// Other variables
$jenkins_api = 'http://localhost:8080/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=awbQveOEOckFL*8Ex4*AbbZWff1SByGq';
//$jenkins_api = 'http://Build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=ZJjA1!!pebeZ$PKsr703x2ReQ7K6OMCU';
?>
