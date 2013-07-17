<?php
fetchFromJenkins();
function fetchFromJenkins(){

	include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
	$granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=ZJjA1!!pebeZ$PKsr703x2ReQ7K6OMCU');
	//echo $granData;
	file_put_contents($jenkins_data, $granData);
	
	//CI
	$granData = file_get_contents("http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=!*qhB2OLIYE!9FBhQHwqobZE!jbybLzt");
	//echo $granData;
	file_put_contents($jenkins_data_ci, $granData);
	
	//Master
	$granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=6m1mhUu2UmARs$nHrfeK2ki6sv3n94Il');
	//echo $granData;
	file_put_contents($jenkins_data_master, $granData);
	
	// PR
	$granData = file_get_contents("http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=munZ6MlNt8O6MZPDq92Ts27mwHuuAjkA");
	//echo $granData;
	file_put_contents($jenkins_data_pr, $granData);

	// Sonar 
	$granData = file_get_contents("http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=WnLv8hr9rJ4wMnEuXpUEC17p3@82Fvbd");
	//echo $granData;
	file_put_contents($jenkins_data_sonar, $granData);
}
?>
