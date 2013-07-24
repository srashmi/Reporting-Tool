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

    public function aggregator($config,$xval,$yval){
            
            $plotValues = array('x'=>'','y'=>'');
            //$start = date('m/d', $timestamp_start);//."-".date('m/d', $timestamp_end);
            //$end = date('m/d', $timestamp_end);
            //echo $xval,",",$yval;
            //echo nl2br("\n\n");
            $date = date_create($config['range']['end']);
            //echo date_format($date, 'Y-m-d H:i:s');
            echo nl2br("\n\n");
            echo $xval,",",date_format($date,'m/d');
            $y=0;
            for($i=$xval;$i<=$dateRangeEnd;$i=i+7){
                for($j=0;$j<7;$j++){
                    $y = $y + $json["dimensions"][0]["values"][$j];
                    //echo "y=", $yval;
                }
                $x=i+7;
                array_push($plotValues['x'],$x);
                array_push($plotValues['y'],$y);

                echo "x and y: ", $x,",",$y;
                echo nl2br("\n\n"); 
            } 
            return $plotValues;

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
            global $display2;$count1=0;
            for ($i = $report_metric; $i < sizeof($json["dimensions"][0]["columns"]); $i=$i+5) {
                $original_timestamp_start = $json["dimensions"][0]["columns"]["$i"]["start"];
                $original_timestamp_end = $json["dimensions"][0]["columns"]["$i"]["end"];
                
                $display=$this->dateFilter($temp_config,$original_timestamp_start,$original_timestamp_end);
                
                if($display){
                    
                    $timestamp_start          = (int) substr($original_timestamp_start, 0, -3);
                    $timestamp_end         = (int) substr($original_timestamp_end, 0, -3);
                    $xval = date('m/d/y', $timestamp_end);//."-".date('m/d', $timestamp_end);
                    $yval = $json["dimensions"][0]["values"][$i];
                    
                    for($i=$timestamp_start;i<=strtotime($temp_config['range']['end']);$i=strtotime($i . ' + 7 day')){
                        echo date('m/d/y',$i);
                        echo nl2br("\n\n");
                    }
                    
                    //echo date('m/d/y',$original_timestamp_start);
                    //echo nl2br("\n\n"); 
                    //echo date('m/d/y',$timestamp_start);
                    //array_push($temp_config['chart']['xAxis']['categories'],$xval);
            	    //array_push($temp_config['chart']['series'][0]['data'], $yval);    
                    // Do aggregation
                    //echo date('m/d/y',$timestamp_start), " , ", date_format(date_create($temp_config['range']['end']),'m/d/y');
                    
                    //for($i=strtotime(date('m/d/y',$timestamp_start));$i<=strtotime($temp_config['range']['end']);$i=strtotime("+7 day", $i)){
                        // for($j=0;$j<7;$j++){
                        //     $y = $y + $json["dimensions"][0]["values"][$j];
                        //     //echo "y=", $yval;
                        // }
                        // $x=i+7;
                        // array_push($plotValues['x'],$x);
                        // array_push($plotValues['y'],$y);
                        //echo date('m/d/y',$i);
                         // echo "x and y: ", $x,",",$y;
                         //echo nl2br("\n\n"); 
                        
                    //} 


                     //$plotValues =$this->aggregator($temp_config,$xval,$yval);
                    // array_push($temp_xval,$plotValues['x']);
                    // array_push($temp_yval,$plotValues['y']);
            	    
                
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
