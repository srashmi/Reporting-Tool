<?php
include('pathconfig.php');
include($jenkins_getter);
class collector{

protected $source;

function __construct($config){
//var_dump($config);
$this->source = $config['admin']['source'];
//echo "Source is: ",$this->source;
}

public function collectData(){
	
switch($this->source){
		case 'jenkins': fetchFromJenkins(); break;
		default: echo "No matching case-",$this->source;
	}

}

}

?>