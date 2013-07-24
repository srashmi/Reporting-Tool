<?php
include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
include($transform);
class jenkinsTransform extends transform{

    var $report_metrics=array(); var $input_file; var $project;
    var $metric_display_names = array('Successful Builds','Failed Builds','Unstable Builds','Aborted Builds','Not Built');
    var $metric_display_colors = array('green','#C34A2C','grey','black','blue');

    public function __construct($project,$metrics, $job){
        include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
        $base_path = $base."/data/granular/".$project."/";
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
                case 'ci': $this->input_file=$base_path."ci.txt"; break;
                case 'master': $this->input_file=$base_path."master.txt"; break;
                case 'pr': $this->input_file=$base_path."pr.txt"; break;
                case 'sonar': $this->input_file=$base_path."sonar.txt"; break;
                case 'all': $this->input_file=$base_path."all.txt"; break;
                default: echo "No matching case",$job;
        };
    }

    public function dateFilter($config, $original_timestamp_start,$original_timestamp_end){
        //echo "in getval";
        $timestamp_start          = (int) substr($original_timestamp_start, 0, -3);
        $timestamp_end         = (int) substr($original_timestamp_end, 0, -3);

        $xval = date('m/d', $timestamp_start);//."-".date('m/d', $timestamp_end);
        $yval = $json["dimensions"][0]["values"][$i];

        $jenkinsStartMonth = strtok($xval,'/');
        $jenkinsStartDay = strtok('/');
        
        $startMon = strtok($config['range']['start'], '/');
        $startDay = strtok('/');
        $endMon = strtok($config['range']['end'], '/');
        $endDay = strtok('/');

        $year = "2013"; // Assumes that only data from 2013 is relevant

        $dateRangeStart = mktime($startMon,$startDay,$year);
        $dateRangeEnd = mktime($endMon,$endDay,$year);
        $jenkinsDate = mktime($jenkinsStartMonth,$jenkinsStartDay,$year);
        //echo $date1;
        if($dateRangeStart<=$jenkinsDate && $dateRangeEnd>$jenkinsDate){
            //echo $jenkinsDate;echo nl2br("\n");
            return true;
        }
        else{
            //echo "else";echo nl2br("\n");
            return false;
            }

    }

    public function transformData($temp_config){
        global $report_metric; 
        $metric_display_names = array('Successful Builds','Failed Builds','Unstable Builds','Aborted Builds','Not Built');
        $metric_display_colors = array('green','#C34A2C','grey','black','blue');
    
        //include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
        //echo "input file: "; echo $this->input_file;    
        $json = json_decode(file_get_contents($this->input_file), true);
        //var_dump($json);
        $temp_xval=array(); $temp_yval=array();
        
        foreach ($this->report_metrics as $report_metric) {
            //echo $report_metric; 
            global $display2;
            for ($i = $report_metric; $i < sizeof($json["dimensions"][0]["columns"]); $i=$i+5) {
                $original_timestamp_start = $json["dimensions"][0]["columns"]["$i"]["start"];
                $original_timestamp_end = $json["dimensions"][0]["columns"]["$i"]["end"];
                
                $display=$this->dateFilter($temp_config,$original_timestamp_start,$original_timestamp_end);
                
                if($display){
                    
                    $timestamp_start          = (int) substr($original_timestamp_start, 0, -3);
                    $timestamp_end         = (int) substr($original_timestamp_end, 0, -3);
                    $xval = date('m/d/y', $timestamp_end);//."-".date('m/d', $timestamp_end);
                    $yval = $json["dimensions"][0]["values"][$i];

                    //original
                    array_push($temp_xval,$xval);
                    array_push($temp_yval,$yval);
                    $display2=$display;
                }
                
            }
            
            if($display2){
                $newItem = array('name'=>$metric_display_names[$report_metric],
                                'align'=>'left',
                                'data'=>array_reverse($temp_yval),
                                'color'=>$metric_display_colors[$report_metric]
                                );
                array_push($temp_config['chart']['series'],$newItem);
            }
            //$temp_config['chart']['series'][$report_metric]['data']  = array_reverse($temp_yval);
            $temp_yval=array();

        }
        $temp_config['chart']['xAxis']['categories'] = array_reverse($temp_xval);       
        //$res = $this->writeJSONData($temp_config);
        //var_dump($temp_config);
        
        return json_encode($temp_config);
    }

}

//echo "<script type=\"text/javascript\">makeGraph(",$config,")</script>";

?>
