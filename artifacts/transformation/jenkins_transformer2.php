<?php
include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
class jenkinsTransform{

	var $report_metrics=array(); 
	var $input_file; 
	var $project;
	var $job;
    
    public function __construct($project,$metrics, $job){
        include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
        $base_path = $base."/data/granular/".$project."/";
        $this->job=$job;
        $this->project=$project;
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
        
    }

    public function dateFilter($start,$end,$dateValue){
		
		$startMon = strtok($start, '/');
    	$startDay = strtok('/');
    	$startYear = strtok('/');

    	$endMon = strtok($end,'/');
    	$endDay = strtok('/');
    	$startYear = strtok('/');

		$dateValueMon = date('m',(int) substr($dateValue, 0, -3));
    	$dateValueDay = date('d',(int) substr($dateValue, 0, -3));
    	$dateValueYear = date('y',(int) substr($dateValue, 0, -3));

		if(mktime($startMon,$startDay,$startYear)<mktime($dateValueMon,$dateValueDay,$dateValueYear)&&mktime($dateValueMon,$dateValueDay,$dateValueYear)<=mktime($endMon,$endDay,$endYear)){
			//echo "within";
			return $dateValueMon."/".$dateValueDay;
		}
		else
			return false;	
	}

	public function transformData($temp_config){
		include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
		$base_path = $base."/data/granular/".$this->project;
		$metric_display_names = array('Successful Builds','Failed Builds','Unstable Builds','Aborted Builds','Not Built');
	    $metric_display_colors = array('green','#C34A2C','grey','black','blue');
		$files = array('success.txt','failure.txt','unstable.txt','aborted.txt','not_built.txt');
        
        $temp_x=array();
        $temp_y=array();
		foreach ($this->report_metrics as $report_metric) {

			$xcount=0;
			
			$this->input_file = $base_path."/".$this->job."/".$files[$report_metric];
			//echo $this->input_file;
			$raw_data = json_decode(file_get_contents($this->input_file), true);
			//var_dump($raw_data);
			
			foreach ($raw_data['date'] as $dateValue){
				$i=0;
				$filterResult = $this->dateFilter($temp_config['range']['start'],$temp_config['range']['end'],$dateValue);
				$newItem = array('name'=>$metric_display_names[$report_metric],
			                                'align'=>'left',
			                                'data'=>$raw_data['builds'],
			                                'color'=>$metric_display_colors[$report_metric]
			                                );
				if($filterResult){
					if($xcount==0) 
						array_push($temp_config['chart']['xAxis']['categories'],$filterResult);
					array_push($newItem['data'],$raw_data['builds'][$i]);
				    
		        }
		        $i++;
		    }
		    array_push($temp_config['chart']['series'],$newItem);
		    $xcount++;
		}
		
		//var_dump($temp_config['chart']['xAxis']['categories']);

		
		return json_encode($temp_config);

	}

	 
}
?>