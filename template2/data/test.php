<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type="text/javascript" src="..\style\chartformatting.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="..\artifacts\renderGraph2.js"></script>

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
include('../data/jenkins-transform.php');
include('../data/transform.php');
include('/Library/WebServer/Documents/php_templates/template2/artifacts/collector.php');

$temp_config = array( 'admin' => array(
										'panel' => 1,
										'source' => "jenkins"
										), //admin
					  'range'=> array(
					  					'start' => '0713', //MMYY
					  					'end' => '0813',
					  				), //range
					  'aggregateBy' => 'month',
					  'chart' => array('chart'=>array('type' => 'column'),
										'title' => array('text'=> 'Overall Build Stats!!!'),
										'subtitle' => array('text' => 'Time of Build (Average per month):'),
			 							'xAxis' => array('categories'=> array()),
										'yAxis' => array('min' => 0,
											'title' => array('text' => 'hey')
 											), //yAxis
 										'tooltip' => array('headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
															'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
//$temp_config['admin']['panel']=1;
echo "something";
$newObject1 = new collector1(); 
$newObject1->collectData();
//$newObject1->findFile($temp_config);
//$res=buildPanel($config);
//echo "<script type=\"text/javascript\">makeGraph()</script>";

?>

</body>
</html>