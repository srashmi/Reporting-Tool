<?php
include($transform);

class jenkinsTransform extends transform{

var $report_metric;
public function __construct($metric){
    
    if($metric=='success')
        $this->report_metric =0;
    if($metric=='failure')
        $this->report_metric =1;
    if($metric=='unstable')
        $this->report_metric =1;
    if($metric=='aborted')
        $this->report_metric =1;
    if($metric=='not_built')
        $this->report_metric =1;
}

public function readGranularData($temp_config){
    global $report_metric;
    include('pathconfig.php');
    $json = json_decode(file_get_contents($jenkins_data), true);
    //var_dump($json);

    $temp_xval=array(); $temp_yval=array();
    
    for ($i = $this->report_metric; $i < sizeof($json["dimensions"][0]["columns"]); $i=$i+5) {
        
        $original_timestamp_start = $json["dimensions"][0]["columns"]["$i"]["start"];
        $original_timestamp_end = $json["dimensions"][0]["columns"]["$i"]["end"];
        $timestamp_start          = (int) substr($original_timestamp_start, 0, -3);
        $timestamp_end         = (int) substr($original_timestamp_end, 0, -3);
        $xval = date('m/d', $timestamp_start);//."-".date('m/d', $timestamp_end);
        $yval = $json["dimensions"][0]["values"][$i];
        //array_push($temp_config['chart']['xAxis']['categories'],$xval);
	   //array_push($temp_config['chart']['series'][0]['data'], $yval);    
	   array_push($temp_xval,$xval);
	   array_push($temp_yval,$yval);
    }
    //$temp_config = array_reverse($temp_config['chart']['xAxis']['categories']);
    //$temp_config = array_reverse($temp_config['chart']['series'][0]['data']);

    $temp_config['chart']['xAxis']['categories'] = array_reverse($temp_xval);     
    $temp_config['chart']['series'][0]['data']  = array_reverse($temp_yval);
    $res = $this->writeJSONData($temp_config);
    return $res;
}

public function writeJSONData($temp_config){

    $tempLabel=$temp_config['chart']['xAxis']['categories'];

    foreach($temp_config['chart']['xAxis']['categories'] as $label){
        $tempLabel = $tempLabel.$label.",";
        echo $templabel;
    }

    $tempDatasets = $temp_config['chart']['series'][0]['data'];
    foreach($temp_config['chart']['series'][0]['data'] as $ds){ 
        $tempDatasets = $tempDatasets.$ds.",";
    }

    $data = json_encode($temp_config);
    // $file = '/Library/WebServer/Documents/php_templates/template2/data/data3.txt';
    // file_put_contents($file, $data);
    return $data;
 }

}

//echo "<script type=\"text/javascript\">makeGraph(",$config,")</script>";

?>
