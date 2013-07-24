<?php
include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/transformation/organizer.php');
$granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=!*qhB2OLIYE!9FBhQHwqobZE!jbybLzt');
	//echo $granData;
	// call organizer
organize($granData,'/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/granular/all/all/');
?>
