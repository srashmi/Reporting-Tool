<?php
//Base path
$base = "/Library/WebServer/Documents/gitdocs/Reporting-Tool";
// Artifact files
$collector = $base."/artifacts/collectors/collector.php";
$dashboard_frame = $base."/artifacts/dashboardFrame.php";
$jenkins_transform = $base."/artifacts/transformation/jenkins_transformer.php";
$jenkins_getter = $base."/artifacts/collectors/jenkinsGetter.php";
$panel_builder = $base."/artifacts/ui/panelBuilder.php";
$transform = $base."/artifacts/transformation/transform.php";
$render_graph = "\Library\WebServer\Documents\gitdocs\Reporting-Tool\artifacts\ui\\renderGraph.js";
$highcharts = "\Library\WebServer\Documents\gitdocs\Reporting-Tool\artifacts\ui\js\highcharts.js";
$exportingjs = "\Library\WebServer\Documents\gitdocs\Reporting-Tool\artifacts\ui\js\modules\exporting.js";
$panel = $base."/artifacts/panel.php";
// Data files
$jenkins_data = $base."/data/granular/jenkinsdata.txt";
$jenkins_data_ci = $base."/data/granular/jenkins_data_ci.txt";
$jenkins_data_master = $base."/data/granular/jenkins_data_master.txt";
$jenkins_data_pr = $base."/data/granular/jenkins_data_pr.txt";
$jenkins_data_sonar = $base."/data/granular/jenkins_data_sonar.txt";
// Styling files
$style = $base."/style/style2.css";

// Other variables
$jenkins_api = 'http://localhost:8080/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=c546i9cBCZjVXjVuJnUsZOJQc3hZpn6n';
//$jenkins_api = 'http://Build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=ZJjA1!!pebeZ$PKsr703x2ReQ7K6OMCU';
?>
