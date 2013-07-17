<?php
include($transform);
//include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
class jenkinsTransform extends transform{

    var $report_metric,$input_file;

    public function __construct($metric, $job){
        include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
        switch($metric){
                case 'success': $this->report_metric =0; break;
                case 'failure': $this->report_metric =1; break;
                case 'unstable': $this->report_metric =2; break;
                case 'aborted': $this->report_metric =3; break;
                case 'not_built': $this->report_metric =4; break;
                default: echo "No matching case-",$metric;
        };
        switch($job){
                case 'ci': $this->input_file=$jenkins_data_ci; break;
                case 'master': $this->input_file=$jenkins_data_master; break;
                case 'pr': $this->input_file=$jenkins_data_pr; break;
                case 'sonar': $this->input_file=$jenkins_data_sonar; break;
                default: echo "No matching case-",$job;
        }
        
    }

    public function transformData($temp_config){
        global $report_metric;
        include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
        //$input_file = $input_file;
        //echo $this->input_file;
        $json = json_decode(file_get_contents($this->input_file), true);
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
        //$res = $this->writeJSONData($temp_config);
        return json_encode($temp_config);
    }

}

//echo "<script type=\"text/javascript\">makeGraph(",$config,")</script>";

?>
