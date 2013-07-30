 <?php

fetchFromJenkins();

function fetchFromJenkins(){
	include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/transformation/organizer.php');
	include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
	$base_path = "/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/granular/";
	
	// ******* All Jobs *******
	$granData = file_get_contents();
	organize($granData,$base_path."all/all/");
	
	//CI
	$granData = file_get_contents("http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=!*qhB2OLIYE!9FBhQHwqobZE!jbybLzt");
	organize($granData,$base_path."all/ci/");
	
	//Master
	$granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=6m1mhUu2UmARs$nHrfeK2ki6sv3n94Il');
	organize($granData,$base_path."all/master/");
	
	// PR
	$granData = file_get_contents("http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=munZ6MlNt8O6MZPDq92Ts27mwHuuAjkA");
	organize($granData,$base_path."all/pr/");

	// Sonar 
	$granData = file_get_contents("http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=WnLv8hr9rJ4wMnEuXpUEC17p3@82Fvbd");
	organize($granData,$base_path."all/sonar/");

	
	// ******* APIM Jobs *******

	//All 
	$granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=SSxdce2YlS36@VyV8Vthan!pFb5fsVPk');
	organize($granData,$base_path.'/apim/all/');

	//CI
	$granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=Ba@ji1mK1S0$5o2o1CQ5dynn3NFLYhcK');
	organize($granData,$base_path.'/apim/ci/');
	
	//Master
	$granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=*A@H@0zaerhh8v!PTXB0l94va!D$MaJf');
	organize($granData,$base_path.'/apim/master/');

	// PR
	$granData = file_get_contents("http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=w8XRXsWraccVmOOsVC6Lo2MuP8Fj!ldy");
	organize($granData,$base_path.'/apim/pr/');

	// Sonar 
	$granData = file_get_contents('http://build.cd.go.com/plugin/global-build-stats/api/json?depth=2&buildStatConfigId=PSTWxB8ny$FveWaTD!UQQBz@p@6LJUk4');
	organize($granData,$base_path.'/apim/sonar/');

}
?>
