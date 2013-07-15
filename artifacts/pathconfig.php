<?php
//Base path
$base = "/Library/WebServer/Documents/gitdocs/Reporting-Tool";
// Artifact files
$collector = $base."/artifacts/collectors/collector.php";
$dashboard_frame = $base."/artifacts/dashboardFrame.php";
$jenkins_transform = $base."/artifacts/transformation/jenkins-transform.php";
$jenkins_getter = $base."/artifacts/collectors/jenkinsGetter.php";
$panel_builder = $base."/artifacts/ui/panelBuilder.php";
$render_graph = $base."/artifacts/ui/renderGraph.js";
$transform = $base."/artifacts/transformation/transform.php";
// Data files
$jenkins_data = $base."/data/granular/jenkinsdata.txt";

// Styling files
$style = $base."/style/style.css";

// Other variables
$jenkins_api = 'http://localhost:8080/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=awbQveOEOckFL*8Ex4*AbbZWff1SByGq';
?>
