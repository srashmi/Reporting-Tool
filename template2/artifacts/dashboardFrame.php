<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type="text/javascript" src="..\style\chartformatting.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="..\artifacts\renderGraph3.js"></script>

<script type="text/javascript" src="..\artifacts\js\highcharts.js"></script>
<script type="text/javascript" src="..\artifacts\js\modules\exporting.js"></script>

<link rel="stylesheet" type="text/css" href="..\style\style.css">
<title>Dashboard</title>
</head>
<body>
<link rel="stylesheet" type="text/css" href="..\style\style.css">
<h2>Dashboard</h2>

<?php 
include('panelBuilder.php');
include('collector.php');
include('../data/jenkins-transform.php'); 

$temp_config = array( 'admin' => array(
										'panel' => 1,
										'source' => 'jenkins',
										'metric' => 'success'
										), //admin
					  'range'=> array(
					  					'start' => '07-07-13', //MM-DD-YY
					  					'end' => '07-07-13',
					  				), //range
					  'aggregateBy' => 'hour',
					  'chart' => array('chart'=>array('type' => 'column'),
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
										 'plotOption' => array('column' => array(
																		'pointPadding' => 0.2,
																		'borderWidth' => 0)
											), //plotoption
										 'series' => array(array(
														'name' => "Number of Failures",
														'data' => array()
												))//series
 									) //chart
 					);


// Panel 1
$temp_config['admin']['panel']=1;
$temp_config['admin']['source']='jenkins';
$temp_config['admin']['metric']='success';
$temp_config['chart']['title']['text'] = 'Successful Builds';
$temp_config['chart']['subtitle']['text'] = 'Total per week';
$temp_config['chart']['series'][0]['name']='Number of Successful Builds';
$obj = new collector($temp_config);
$obj->collectData();
$newObject = new jenkinsTransform(); 
$config = $newObject->readGranularData($temp_config); 
$res=buildPanel($config);
echo "<script type=\"text/javascript\">makeGraph(",$config,")</script>";

// Panel 2
$temp_config['admin']['panel']=2;
$temp_config['admin']['source']='jenkins';
$temp_config['admin']['metric']='failure';
$temp_config['chart']['series'][0]['name']='Number of Failed Builds';
$temp_config['chart']['title']['text'] = 'Failed Builds';
$temp_config['chart']['subtitle']['text'] = 'Total per week';
$obj = new collector($temp_config);
$obj->collectData();
$newObject = new jenkinsTransform(); 
$config = $newObject->readGranularData($temp_config); 
$res=buildPanel($config);
echo "<script type=\"text/javascript\">makeGraph(",$config,")</script>";

// Panel 3
// $temp_config['admin']['panel']=3;
// $newObject = new transform(); 
// $config_local = $newObject->readGranularData($temp_config); 
// $config=json_encode($config_local);
// $res=buildPanel($config_local);
// echo "<script type=\"text/javascript\">makeGraph(",$config,")</script>";
// 
// Panel 4
// $temp_config['admin']['panel']=4;
// $newObject = new transform(); 
// $config_local = $newObject->readGranularData($temp_config); 
// $config=json_encode($config_local);
// $res=buildPanel($config_local);
// echo "<script type=\"text/javascript\">makeGraph(",$config,")</script>";

/*

//Panel 4

$config_local[panel]=4;
$config=json_encode($config_local);
$res=buildPanel($config);
echo "<script type=\"text/javascript\">makeGraph(",$config,")</script>";

*/
?>

</body>
</html>
