<?php
fetchFromJenkins();
function fetchFromJenkins(){

	include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
	//$granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=ZJjA1!!pebeZ$PKsr703x2ReQ7K6OMCU');
	$base_path = "/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/granular/";
	// ******* All Jobs *******

	$granData = file_get_contents($jenkins_api);
	//echo $granData;
	// call organizer
	file_put_contents($base_path."all/all.txt", $granData);
	
	//CI
	$granData = file_get_contents("http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=!*qhB2OLIYE!9FBhQHwqobZE!jbybLzt");
	//echo $granData;
	file_put_contents($base_path."all/ci.txt", $granData);
	
	//Master
	$granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=6m1mhUu2UmARs$nHrfeK2ki6sv3n94Il');
	//echo $granData;
	file_put_contents($base_path."all/master.txt", $granData);
	
	// PR
	$granData = file_get_contents("http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=munZ6MlNt8O6MZPDq92Ts27mwHuuAjkA");
	//echo $granData;
	file_put_contents($base_path."all/pr.txt", $granData);

	// Sonar 
	$granData = file_get_contents("http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=WnLv8hr9rJ4wMnEuXpUEC17p3@82Fvbd");
	//echo $granData;
	file_put_contents($base_path."all/sonar.txt", $granData);

	
	// ******* APIM Jobs *******

	//All 

	// $granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=SSxdce2YlS36@VyV8Vthan!pFb5fsVPk');
	// //echo $granData;
	// file_put_contents("/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/granular/apim/all.txt", $granData);

	// //CI
	// $granData = file_get_contents("http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=Ba@ji1mK1S0$5o2o1CQ5dynn3NFLYhcK");
	// //echo $granData;
	// file_put_contents("/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/granular/apim/ci.txt", $granData);
	
	$granData = file_get_contents('http://localhost:8080/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=c546i9cBCZjVXjVuJnUsZOJQc3hZpn6n');
	//echo $granData;
	file_put_contents("/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/granular/apim/all.txt", $granData);

	//CI
	$granData = file_get_contents("http://localhost:8080/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=KF7sA6XXek5wd90u6IM6ViUdbPS*ii0f ");
	//echo $granData;
	file_put_contents("/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/granular/apim/ci.txt", $granData);
	
	// ==========
	//Master
	$granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=*A@H@0zaerhh8v!PTXB0l94va!D$MaJf');
	//echo $granData;
	file_put_contents("/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/granular/apim/master.txt", $granData);
	
	// PR
	$granData = file_get_contents("http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=w8XRXsWraccVmOOsVC6Lo2MuP8Fj!ldy");
	//echo $granData;
	file_put_contents("/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/granular/apim/pr.txt", $granData);

	// Sonar 
	$granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=PSTWxB8ny$FveWaTD!UQQBz@p@6LJUk4');
	//echo $granData;
	file_put_contents("/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/granular/apim/sonar.txt", $granData);

}
?>
