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

                $dateValueMon = date('m',(int) substr($date, 0, -3));
                $dateValueDay = date('d',(int) substr($date, 0, -3));
                $dateValueYear = date('y',(int) substr($date, 0, -3));


                //array_push($json['date'], $date);
                array_push($json['date'], date('m/d/y',(int) substr($date, 0, -3)));
                array_push($json['builds'], $builds);
                //echo "File: ",$file;
                echo nl2br("\n\n");
            }
            echo "file: ",$files[$i];
            file_put_contents($base_path.$files[$i], json_encode($json));
            //var_dump($json);
            echo nl2br("\n\n");
        }

}

?>
