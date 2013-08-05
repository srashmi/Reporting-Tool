<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="..\artifacts\ui\renderGraph.js"></script>
<script type="text/javascript" src="..\artifacts\ui\js\highcharts.js"></script>
<script type="text/javascript" src="..\artifacts\ui\js\modules\exporting.js"></script>
<link rel="stylesheet" type="text/css" href="..\style\style.css">
<title>Dashboard</title>
</head>
<body>
<h2>Dashboard</h2>
<nav>
  <a href="/gitdocs/Reporting-Tool/artifacts/dashboard.php?project=all">All</a> |
  <a href="/gitdocs/Reporting-Tool/artifacts/dashboard.php?project=apim">APIM</a> |
  <a href="/bde/">BDE</a> |
  <a href="/cms/">CMS</a> |
  <a href="/cst/">CST</a> |
  <a href="/dbe/">DBE</a> |
  <a href="/ds/">Data Solutions</a> |
  <a href="/did/">DisneyID</a> |
  <a href="/espn/">ESPN</a> |
  <a href="/ics/">ICS</a> |
  <a href="/mcon/">MCON</a> |
  <a href="/qa/">QA</a> |
  <a href="/syseng/">System Engineering</a> |
  <a href="/um/">UM</a>
</nav> 

<?php 
include('pathconfig.php');
include($panel_builder);
//include($collector);
include($jenkins_transform); 
include($panel);

$project = $_GET["project"];
if($project==NULL)
	$project='all';
//echo "project: "; echo $project;
$temp_config = array( 'admin' => array(
										'panel' => 1,
										'project' =>$project
										), //admin
					  'range'=> array(
					  					'start' => '01/06/13', // MM/DD/YY
					  					'end' => '07/17/13',
					  				), //range
					  'aggregateBy' => "month",
					  'chart' => array('chart'=>array('type' => 'column'
					  							
					  							),
										'title' => array('text'=> '',
														 'align' => 'left'
													),	
										
										'subtitle' => array('text' => '',
																'align' => 'left'),
										'legend' => array(
														'align' => 'left',
														'layout' => 'vertical',
														'floating' => 'true',
														'x' => 60,
														'y' => -90
													),
			 							'xAxis' => array('categories'=> array(),
			 												'title' => array(
			 															'text' => ''
			 														)
			 											),
										'yAxis' => array(
															'min' => 0,
															'title' => array('text' => 'Number of Builds'),
															'minorTickInterval' => 'auto'	
														), //yAxis
 										'tooltip' => array('headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
															'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
															'footerFormat' => '</table>',
													     	'shared' => true,
															'useHTML' => true
															), //tooltip
										'plotOptions' => array('column' => array(
																		'pointPadding' => 0.2,
																		'borderWidth' => 0
																		)
															),//plotoption
										 'series' => array(
													 		
															
												)//series
 									) //chart
 					);

//Panel 1
$panel1_config = $temp_config;
$panel1_config['admin']['panel']=1;
$panel1_config['chart']['title']['text'] = 'Build Statistics - All Jobs';
//array_push($panel1_config['chart']['chart'], 'width');
//$panel1_config['chart']['chart']['width'] = 2500;
$panel1_config['range']['start'] = '06/01/13';
$panel1_config['range']['end'] = '07/30/13';

//Panel 2
$panel2_config = $temp_config;
$panel2_config['admin']['panel']=2;
$panel2_config['range']['start'] = '06/01/13';
$panel2_config['range']['end'] = '07/14/13';
$panel2_config['chart']['title']['text'] = 'Build Statistics - CI';
//array_push($panel2_config['chart']['chart'], 'width');
//$panel2_config['chart']['chart']['width'] = 2500;

//Panel 3
$panel3_config = $temp_config;
$panel3_config['admin']['panel']=3;
$panel3_config['chart']['title']['text'] = 'Build Statistics - PR';
//array_push($panel3_config['chart']['chart'], 'width');
//$panel3_config['chart']['chart']['width'] = 2500;
$panel2_config['range']['start'] = '06/01/13';
$panel2_config['range']['end'] = '07/14/13';

//Panel 4
$panel4_config = $temp_config;
$panel4_config['admin']['panel']=4;
$panel4_config['chart']['title']['text'] = 'Build Statistics - Master';
//array_push($panel4_config['chart']['chart'], 'width');
//$panel4_config['chart']['chart']['width'] = 2500;
$panel2_config['range']['start'] = '06/01/13';
$panel2_config['range']['end'] = '07/14/13';

// panelObject = new Panel(transformationObj, panelConfig)
// jenkinsTransformObject = new jenkinsTransform(project_name_from_selection,array('success'|'failure'|'unstable'|'aborted'|'not_built'|'all'),'ci','master','pr','sonar')
 
 $panels = array(
 	new Panel(new jenkinsTransform($panel1_config['admin']['project'],array('success','failure','aborted'),'all'), $panel1_config),
 	new Panel(new jenkinsTransform($panel2_config['admin']['project'],array('success','failure','not_built'),'master'), $panel2_config),
 	new Panel(new jenkinsTransform($panel3_config['admin']['project'],array('success','failure'),'ci'), $panel3_config),
 	new Panel(new jenkinsTransform($panel4_config['admin']['project'],array('success','failure'),'pr'), $panel4_config)
 );

// $panels = array(
//   	new Panel(new jenkinsTransform($panel3_config['admin']['project'],array('success','failure','aborted'),'ci'), $panel1_config),
//   	  ); 


foreach($panels as $panel) {
	$panel->printHtml();
}
?>
</body>
</html>
