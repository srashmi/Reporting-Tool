<?php
include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
//include($transform);

    function organize($granularData,$base_path){
        
        $data=json_decode($granularData,true);
        //var_dump($data);
        //echo sizeof($data["dimensions"][0]["columns"]);
        $files = array('success.txt','failure.txt','unstable.txt','aborted.txt','not_built.txt');
        for($i=0;$i<5;$i++){
            $json = array("date"=>array(),
                            "builds" => array());
            for($j=$i;$j<sizeof($data["dimensions"][0]["columns"]); $j=$j+5){
                $date=$data["dimensions"][0]["columns"][$j]["end"];
                $builds=$data["dimensions"][0]["values"][$j];
                array_push($json['date'], $date);
                array_push($json['builds'], $builds);
                //echo "File: ",$file;
                echo nl2br("\n\n");
            }
            echo "file: ",$files[$i];
            file_put_contents($base_path.$files[$i], json_encode($json));
            //var_dump($json);
            echo nl2br("\n\n");
        }


        // global $report_metric; 
        // $metric_display_names = array('Successful Builds','Failed Builds','Unstable Builds','Aborted Builds','Not Built');
        // $metric_display_colors = array('green','#C34A2C','grey','black','blue');
    
        // //include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
        // //echo "input file: "; echo $this->input_file;    
        // $json = json_decode(file_get_contents($this->input_file), true);
        // //var_dump($json);
        //  $temp_xval=array(); 
        //  $temp_yval=array();
        //  $temp_vals=array('date'=>array(),'builds'=>array());
        
        // foreach ($this->report_metrics as $report_metric) {
        //     //echo $report_metric; 
        //     global $display2;$count1=0;

        //     for ($i = $report_metric; $i < sizeof($json["dimensions"][0]["columns"]); $i=$i+5) {
        //         //$original_timestamp_start = $json["dimensions"][0]["columns"]["$i"]["start"];
        //         $original_timestamp_end = $json["dimensions"][0]["columns"]["$i"]["end"];
        //         $yval = $json["dimensions"][0]["values"][$i];
                    
        //             //original
        //             array_push($temp_vals['date'],$xval);
        //             array_push($temp_yval['builds'],$yval);

                    
                    

                
          //  }
            
    //}
}


//echo "<script type=\"text/javascript\">makeGraph(",$config,")</script>";

?>
