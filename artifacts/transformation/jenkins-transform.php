<?php
include($transform);
//include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
class jenkinsTransform extends transform{

    var $report_metrics=array(); var $input_file;
    var $metric_display_names = array('Successful Builds','Failed Builds','Unstable Builds','Aborted Builds','Not Built');
    var $metric_display_colors = array('green','#C34A2C','grey','black','blue');
    public function __construct($metrics, $job){
        include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
        foreach ($metrics as $metric){
            switch($metric){
                    case 'success': array_push($this->report_metrics,0); break;
                    case 'failure': array_push($this->report_metrics,1); break;
                    case 'unstable': array_push($this->report_metrics,2); break;
                    case 'aborted': array_push($this->report_metrics,3); break;
                    case 'not_built': array_push($this->report_metrics,4); break;
                    default: echo "No matching case-",$metric;
            };
        }
        switch($job){
                case 'ci': $this->input_file=$jenkins_data_ci; break;
                case 'master': $this->input_file=$jenkins_data_master; break;
                case 'pr': $this->input_file=$jenkins_data_pr; break;
                case 'sonar': $this->input_file=$jenkins_data_sonar; break;
                case 'all': $this->input_file=$jenkins_data; break;
                default: echo "No matching case-",$job;
        };
    }

    public function transformData($temp_config){
        global $report_metric; 
        $metric_display_names = array('Successful Builds','Failed Builds','Unstable Builds','Aborted Builds','Not Built');
        $metric_display_colors = array('green','#C34A2C','grey','black','blue');
    
        //include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
        $json = json_decode(file_get_contents($this->input_file), true);
        //var_dump($json);
        $temp_xval=array(); $temp_yval=array();
        
        foreach ($this->report_metrics as $report_metric) {
            //echo $report_metric;
            for ($i = $report_metric; $i < sizeof($json["dimensions"][0]["columns"]); $i=$i+5) {
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
            $newItem = array('name'=>$metric_display_names[$report_metric],
                            'align'=>'left',
                            'data'=>array_reverse($temp_yval),
                            'color'=>$metric_display_colors[$report_metric]
                            );
            array_push($temp_config['chart']['series'],$newItem);
            //$temp_config['chart']['series'][$report_metric]['data']  = array_reverse($temp_yval);
            $temp_yval=array();

        }
        $temp_config['chart']['xAxis']['categories'] = array_reverse($temp_xval);       
        //$res = $this->writeJSONData($temp_config);
        return json_encode($temp_config);
    }

}

//echo "<script type=\"text/javascript\">makeGraph(",$config,")</script>";

?>
