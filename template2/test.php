<?php
echo "blah2";

$temp_config = array('range'=> 'blah',
					  'aggregateBy' => 'month',
					  'chart' => array('type' => 'column',
										'title' => array('text'=> 'Overall Build Stats'),
										'subtitle' => array('text' => 'Time of Build (Average per month)'),
			 							'xAxis' => array('categories'=> array(1,2)),
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
										'series' => array(
														'name' => "Number of Failures",
														'data' => array(1,1)
												)//series
 									) //chart
 					);
					
echo $temp_config['chart']['series']['name'];

echo "json_encode($config_local)-> ",json_encode($temp_config);

$data = json_encode($temp_config);
echo "*******",$data;
$file = 'data5.txt';
file_put_contents($file, $data);

?>
