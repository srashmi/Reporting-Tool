<?php

class Panel {

	var $panel_config;
	var $transformer;
	
	function __construct($source,$panel_config){
		$this->panel_config=$panel_config;
		$this->transformer = $source;
	}

	function printHtml() {
		$config = $this->transformer->transformData($this->panel_config); 
		//var_dump($config);
		buildPanel($config);
		echo "<script type=\"text/javascript\">makeGraph(",$config,")</script>";
		
	}

	function buildPanel($config) {
		$data_source = json_decode($config);
		$data_source_panelid = $data_source->admin->panel;
		//echo "panel=",$data_source_panelid;
		echo "<section id=\"panel",$data_source_panelid,"\">
		<div id=\"graph",$data_source_panelid,"\"></div>
		</section>";
	}
}
?>