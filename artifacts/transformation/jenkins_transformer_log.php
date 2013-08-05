<?php
//include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
class jenkinsTransformFromLog{

	var $report_metrics=array(); 
	var $input_file; 
	var $project;
	var $job;
    
    public function __construct($project,$metrics, $job){
        //include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
        //$base_path = $base."/data/granular/".$project."/";
        $base_path = '/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/log_data/'.$job;
        //$base_path = '/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/demoData/'.$job;
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

	public function aggregateData($temp_config){

		$builds=$temp_config['chart']['series'];
		$arr_weeks=array();
	
		if($temp_config['aggregateBy']=='month'){	
			foreach ($temp_config['chart']['xAxis']['categories'] as $xval) {
				array_push($arr_weeks,date('m',strtotime($xval)));
			}
		}
		
		if($temp_config['aggregateBy']=='week'){
			foreach ($temp_config['chart']['xAxis']['categories'] as $xval) {
				array_push($arr_weeks,date('W',strtotime($xval)));
			}
		}

		if($temp_config['aggregateBy']=='day'){
			return $temp_config;
		}
		$counts_temp=array_count_values($arr_weeks);
		$counts=array();
		foreach($counts_temp as $key){
			array_push($counts,$key);
		}
		$i_count=0;
		$vals=array();
		$cumulative_counts=array(0);

		for($i=0;$i<count($counts);$i++){
			$i_count+=$counts[$i];
			array_push($cumulative_counts,$i_count);
		}
		$total=array();
		
		for($j=0;$j<count($builds);$j++){
			for($i=0;$i<count($counts);$i++){
				$ans=0;
				for($index=$cumulative_counts[$i];$index<$cumulative_counts[$i+1];$index++){
					
					$ans=$ans+$builds[$j]['data'][$index];
					
				}
				$vals[$i]=$ans;

			}
			array_push($total,$vals);

		}
		$i=0;
		
		foreach ($temp_config['chart']['series'] as $key) {
			$temp_config['chart']['series'][$i]['data']=array();
			$temp_config['chart']['series'][$i]['data']=array_reverse($total[$i]);
			$i++;
		}
		$temp_config['chart']['xAxis']['categories'] =array();
		$temp_xvals = array_unique($arr_weeks);
		$months=array(
					"01"=>"Jan",
					"02"=>"Feb",
					"03"=>"Mar",
					"04"=>"Apr",
					"05"=>"May",
					"06"=>"Jun",
					"07"=>"Jul",
					"08"=>"Aug",
					"09"=>"Sep",
					"10"=>"Oct",
					"11"=>"Nov",
					"12"=>"Dec"
					);
		$temp_xvals=array_reverse($temp_xvals);

		if($temp_config['aggregateBy']=="month"){
			foreach ($temp_xvals as $key) {
				array_push($temp_config['chart']['xAxis']['categories'],$months[$key]);
			}
		}

		if($temp_config['aggregateBy']=="week"){
			foreach ($temp_xvals as $key) {
				array_push($temp_config['chart']['xAxis']['categories'],$key);
			}
		}

		return ($temp_config);
	}

	public function transformData($temp_config){
		//include('/Library/WebServer/Documents/gitdocs/Reporting-Tool/artifacts/pathconfig.php');
		//$base_path = $base."/data/granular/".$this->project;
		//$base_path = '/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/log_data/'.$this->job;
		$base_path = '/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/log_data/'.$this->project."/".$this->job;
        
		$metric_display_names = array('Successful Builds','Failed Builds','Unstable Builds','Aborted Builds','Not Built');
	    $metric_display_colors = array('green','#C34A2C','grey','black','blue');
		$files = array('success.txt','failure.txt','unstable.txt','aborted.txt','not_built.txt');
        
        $temp_config['chart']['title']['text'] = 'Build Statistics - '.$this->job;
        $temp_x=array();
        $temp_y=array();$xcount=0;
        $newItem = array('name'=>'',
			             'align'=>'left',
                        'data'=>array(),
                        'color'=>''
                        );
        //$temp_config['chart']['series']=array(array());
       foreach ($this->report_metrics as $report_metric) {
			//$this->input_file = $base_path."/".$this->job."/".$files[$report_metric];
			$this->input_file = $base_path."/".$files[$report_metric];
			//echo $this->input_file;
			$raw_data = json_decode(file_get_contents($this->input_file), true);
			$j=0;
			//var_dump($raw_data);
		    $temp_config['chart']['xAxis']['categories']=$raw_data['date'];
		    $newItem['name']=$metric_display_names[$report_metric];
		    $newItem['color']=$metric_display_colors[$report_metric];
		    $newItem['data']=$raw_data['builds'];
		    array_push($temp_config['chart']['series'],$newItem);
		    //$xcount++;

		}
		//var_dump($temp_config['chart']['series']);
		$config = $this->aggregateData($temp_config);
		//var_dump($config);
		return json_encode($config);
		
	}

	 
}
?>