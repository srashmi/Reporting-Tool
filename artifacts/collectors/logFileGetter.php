<?php
date_default_timezone_set('America/Los_Angeles');
getFiles();
$projects = array('apim','bde','cms','cst','dbe','Data Solutions','DisneyID','ESPN','ICS','MCON','QA','System Engineering','UM');
foreach($projects as $project){
	//getLogData($project);
}
function getFiles(){
	//$base = '/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/demoData/';
	$base='/Users/rshekhar/disney-plugin/disney-github-enterprise-plugin/work/jobs/';

	$all_dirs = scandir($base);
	$files = array_diff($all_dirs, array('.', '..'));
	//var_dump($files);

	$job_names=array('ci','pr','master','sonar');
	$job_names=array('ci');

	// foreach ($files as $file) {
	// 	$file_tokens=explode('.',$file);
	// 	$count= count($file_tokens);
	// 	$job = $file_tokens[$count-1];
	// 	$proj = $file_tokens[1];
	// 	$write_file_base='/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/log_data2/';
	// 	//$file_base=$base.$file.'/builds';
	// 	$file_base='/Users/rshekhar/disney-plugin/disney-github-enterprise-plugin/work/jobs/'.$file.'/builds';
	// }

		$projects=array('bde');
		
		foreach ($projects as $project) {
			$projbuilds_ci=array();
			$projbuilds_pr=array();
			$projbuilds_master=array();
			$projbuilds_sonar=array();
			foreach ($files as $file) {
				//echo $file, ",",$project,"<br>";
				if(strpos($file,$project)){
					$file_tokens=explode('.',$file);
					$count= count($file_tokens);
					$job = $file_tokens[$count-1];

					//echo "job-",$job;
					switch($job){
						case "ci":array_push($projbuilds_ci,$file);break;
						case "pr":array_push($projbuilds_pr,$file);break;
						case "master":array_push($projbuilds_master,$file);break;
						case "sonar":array_push($projbuilds_sonar,$file);break;
						default: echo "nf";
					}
					//array_push($projbuilds,$file);
				}
			
			}
			// var_dump($projbuilds_ci);
			// echo "<br/>";
			// var_dump($projbuilds_pr);
			// echo "<br/>";
			// var_dump($projbuilds_master);
			// echo "<br/>";
			// var_dump($projbuilds_sonar);
			// echo "<br/>";
			// echo "-------------";

			//call saving method
			$allFiles = array("ci"=>$projbuilds_ci,
									"pr"=>$projbuilds_pr,
									"master"=>$projbuilds_master,
									"sonar"=>$projbuilds_sonar
									);
			//var_dump($allFiles);
			getLogData($project,$allFiles);
		}
		
	


}

function getLogData($project,$allFiles){

	//$job_names=array('ci','pr','master','sonar');
	//$job_names=array('test2','test3','Sample BDE Project');
	$job_names=array('ci','pr','master','sonar');
	$base='/Users/rshekhar/disney-plugin/disney-github-enterprise-plugin/work/jobs/';
	foreach ($job_names as $job_name) {

		//$write_file_base='/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/log_data/'.$project."/";
		$write_file_base='/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/log_data/';
		$all_dirs=array();
		foreach($allFiles[$job_name] as $eachjob){
			foreach(scandir($base.$eachjob."/builds") as $eachfile)
			array_push($all_dirs,$eachfile);
		}
		//$all_dirs = scandir($file_base);
		//var_dump($all_dirs);
		$cleanup=array();
		foreach($all_dirs as $dir){
			if(substr($dir,0,4)!='2013'){
				array_push($cleanup,$dir);
			}
		}
		$short_dirs=array();
		$dirs=array_diff($all_dirs,$cleanup);
		//echo "****<br />";

		foreach ($dirs as $key) {
			$val= date('m/d/y',strtotime(substr($key,0,10)));
			array_push($short_dirs,$val);
		}
		//var_dump($short_dirs);

		$dates=array();$status=array();$successes=array();$failures=array();$aborts=array();
		//$dirs=array('2013-06-27_15-05-26');

		//fill in all arrays with dates from Apr till today
		$end=mktime();
		$start=strtotime("-4 months", $end); 
		for($i=$start; $i<=$end; $i=strtotime("+1day",$i)) { 
		        $date= date("m/d/y", $i); 
		        $successes[$date]=0;
		        $failures[$date]=0;
		        $aborts[$date]=0;
		}

		//var_dump($successes);
		
		//create the dates and statuses arrays from the build.xml info
		foreach($dirs as $dir){

			$val = date('m/d/y',strtotime(substr($dir,0,10)));
			array_push($dates,$val);

			foreach($allFiles[$job_name] as $eachjob){
				$file_path=$base.$eachjob."/builds/".$dir."/build.xml";

				if (file_exists($file_path)) {
				    $xml = simplexml_load_file($file_path);
				    
				    $stat=(string)($xml->result);
				   	array_push($status,$stat);
				}
				else {
					//echo $file_path;
				    //exit('Failed to open file.');
				}
			}

		}
		//var_dump($status);
		
		for($i=0;$i<count($status);$i++){
			switch($status[$i]){
				case 'SUCCESS': $date=$dates[$i];
								$successes[$date]++;break;
				case 'FAILURE': $date=$dates[$i];
								$failures[$date]++; break;
				case 'ABORTED': $date=$dates[$i];
								$aborts[$date]++; break;
				default: echo "no match";
			}	
		}

		$metrics = array('success'=>$successes,
						'failure'=>$failures,
						'aborted'=>$aborts
						);
		//var_dump($metrics);

		foreach ($metrics as $metric_name => $metric ) {
			$object = array('date'=>array(),
						'builds'=>array()
						);
			foreach ($metric as $key => $value) {
				array_push($object['date'],$key);
				array_push($object['builds'],$value);
			}	
			$output_file=$write_file_base.$project."/".$job_name."/".$metric_name.".txt";
			//$output_file=$write_file_base.$job_name."/".$metric_name.".txt";
			echo $output_file;
			file_put_contents($output_file, json_encode($object));
		}


	}
}

function getFiles3(){
	//$base= '/data/jenkins_jobs/jobs/';
	$base = '/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/demoData/';
	
	$all_dirs = scandir($base);
	$files = array_diff($all_dirs, array('.', '..'));
	//var_dump($files);

	$job_names=array('ci','pr','master','sonar');
	$job_names=array('ci');
	
	foreach ($files as $file) {
		$file_tokens=explode('.',$file);
		$count= count($file_tokens);
		$job = $file_tokens[$count-1];
		$proj = $file_tokens[1];
		$write_file_base='/Library/WebServer/Documents/gitdocs/Reporting-Tool/data/log_data2/';
		//$file_base=$base.$file.'/builds';
		$file_base='/Users/rshekhar/disney-plugin/disney-github-enterprise-plugin/work/jobs/'.$file.'/builds';
		$projects=array('bde');
		
		foreach($projects as $project){
			
			foreach($job_names as $job_name){
				$all_dirs=array();
				foreach($projects as $project){
					$all_dirs=array();
					foreach($job_names as $job_name){
						if(strpos($file,$project)&&strpos($file, $job_name)){
							array_push($all_dirs,$file);
						}
					}
				}

				
				if(count($all_dirs)>0){
					//$all_dirs = scandir($file_base);
					var_dump($all_dirs);
					$cleanup=array();
					foreach($all_dirs as $dir){
						if(substr($dir,0,4)!='2013'){
							array_push($cleanup,$dir);
						}
					}
					$short_dirs=array();
					$dirs=array_diff($all_dirs,$cleanup);
					foreach ($dirs as $key) {
						$val= date('m/d/y',strtotime(substr($key,0,10)));
						array_push($short_dirs,$val);
					}
					//var_dump($short_dirs);

					$dates=array();$status=array();$successes=array();$failures=array();$aborts=array();
					//$dirs=array('2013-06-27_15-05-26');

					//fill in all arrays with dates from Apr till today
					$end=mktime();
					$start=strtotime("-4 months", $end); 
					for($i=$start; $i<=$end; $i=strtotime("+1day",$i)) { 
					        $date= date("m/d/y", $i); 
					        $successes[$date]=0;
					        $failures[$date]=0;
					        $aborts[$date]=0;
					}

					//var_dump($successes);
					
					//create the dates and statuses arrays from the build.xml info
					foreach($dirs as $dir){
						$val = date('m/d/y',strtotime(substr($dir,0,10)));
						array_push($dates,$val);
						$file_path=$file_base."/".$dir."/build.xml";

						if (file_exists($file_path)) {
						    $xml = simplexml_load_file($file_path);
						    
						    $stat=(string)($xml->result);
						   	array_push($status,$stat);
						}
						else {
							echo $file_path;
						    exit('Failed to open file.');
						}

					}
					
					for($i=0;$i<count($status);$i++){
						switch($status[$i]){
							case 'SUCCESS': $date=$dates[$i];
											$successes[$date]++;break;
							case 'FAILURE': $date=$dates[$i];
											$failures[$date]++; break;
							case 'ABORTED': $date=$dates[$i];
											$aborts[$date]++; break;
							default: echo "no match";
						}	
					}

					$metrics = array('success'=>$successes,
									'failure'=>$failures,
									'aborted'=>$aborts
									);

					foreach ($metrics as $metric_name => $metric ) {
						$object = array('date'=>array(),
									'builds'=>array()
									);
						foreach ($metric as $key => $value) {
							array_push($object['date'],$key);
							array_push($object['builds'],$value);
						}	
						$output_file=$write_file_base.$proj."/".$job."/".$metric_name.".txt";
						//$output_file=$write_file_base.$job_name."/".$metric_name.".txt";
						//echo "file",$output_file;
						//echo "<br/>";
						file_put_contents($output_file, json_encode($object));
					}
				}
		}

	}

}
}
?>