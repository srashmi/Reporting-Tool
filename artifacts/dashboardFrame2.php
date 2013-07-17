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

<?php 
include('pathconfig.php');
include($panel_builder);
//include($collector);
include($jenkins_transform); 
include($panel);

$temp_config = array( 'admin' => array(
										'panel' => 1,
										
										), //admin
					  'range'=> array(
					  					'start' => '07-07-13', //MM-DD-YY
					  					'end' => '07-07-13',
					  				), //range
					  'aggregateBy' => 'hour',
					  'chart' => array('chart'=>array('type' => 'line'),
										'title' => array('text'=> ''),	
										'subtitle' => array('text' => ''),
			 							'xAxis' => array('categories'=> array()),
										'yAxis' => array('min' => 0,
											'title' => array('text' => '')
 											), //yAxis
 										'tooltip' => array('headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
															'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
															'footerFormat' => '</table>',
													     	'shared' => true,
															'useHTML' => true
															), //tooltip
										 'plotOptions' => array('column' => array(
																		'pointPadding' => 0.2,
																		'borderWidth' => 0),
										 						'series' => array(
										 								'color' => 'black'
										 								)
											), //plotoption
										 'series' => array(array(
														'name' => "Number of Failures",
														'data' => array()
												))//series
 									) //chart
 					);

//Panel 1
$panel1_config = $temp_config;
$panel1_config['admin']['panel']=1;
$panel1_config['chart']['title']['text'] = 'Successful CI Builds';
$panel1_config['chart']['subtitle']['text'] = 'Total per week';
$panel1_config['chart']['series'][0]['name']='Number of Successful Builds';
$panel1_config['chart']['plotOptions']['series']['color']='green';

//Panel 2
$panel2_config = $temp_config;
$panel2_config['admin']['panel']=2;
$panel2_config['chart']['series'][0]['name']='Number of Failed Builds';
$panel2_config['chart']['title']['text'] = 'Failed CI Builds';
$panel2_config['chart']['subtitle']['text'] = 'Total per week';
$panel2_config['chart']['plotOptions']['series']['color']='red';

//Panel 3
$panel3_config = $temp_config;
$panel3_config['admin']['panel']=3;
$panel3_config['chart']['series'][0]['name']='Number of Successful Builds';
$panel3_config['chart']['title']['text'] = 'Successful Master Builds';
$panel3_config['chart']['subtitle']['text'] = 'Total per week';
$panel3_config['chart']['plotOptions']['series']['color']='green';

//Panel 4
$panel4_config = $temp_config;
$panel4_config['admin']['panel']=4;
$panel4_config['chart']['series'][0]['name']='Number of Failed Builds';
$panel4_config['chart']['title']['text'] = 'Failed Master Builds';
$panel4_config['chart']['subtitle']['text'] = 'Total per week';
$panel4_config['chart']['plotOptions']['series']['color']='red';

// panelObject = new Panel(transformationObj, panelConfig)
// jenkinsTransformObject = new jenkinsTransform('success'|'failure'|'unstable'|'aborted'|'not_built','ci','master','pr','sonar')
 $panels = array(
 	new Panel(new jenkinsTransform('success','ci'), $panel1_config),
 	new Panel(new jenkinsTransform('failure','ci'), $panel2_config),
 	new Panel(new jenkinsTransform('success','pr'), $panel3_config),
 	new Panel(new jenkinsTransform('failure','master'), $panel4_config)
 );

foreach($panels as $panel) {
	$panel->printHtml();
}

?>

</body>
</html>
