<?php
$file="data3.txt";
$json = json_decode(file_get_contents($file),true);
var_dump($json);
//echo $json["dimensions"][0]["columns"][0]["end"];
echo "Length: ", sizeof($json["dimensions"][0]["columns"]);
for($i=0;$json["dimensions"][0]["values"][$i]!=null;$i++){
echo nl2br("i = ");echo $i;
echo nl2br(";Value = ");
echo $json["dimensions"][0]["values"][$i];
echo nl2br(";Cols: ");
echo $json["dimensions"][0]["columns"]["$i"]["end"], " - ";
echo $json["dimensions"][0]["columns"]["$i"]["start"];
echo nl2br("\n");
echo nl2br("\n");
}

$original_timestamp = $json["dimensions"][0]["columns"]["$i"]["end"];
$timestamp = (int) substr($original_timestamp,0,-3);

echo date('m',$timestamp);

/*
foreach($json as $key => $value) {
    echo "----key1 =",$key;
        foreach ($value as $key2 => $value2) {
          echo "---key2 =" , $key2;
		foreach ($value2 as $key3 => $value3) {
          echo "---
key3 =" , $key3;
	  foreach($value3 as $key4 => $value4) {
          echo "\n\n\n" ,"\n","\n", $key4;

    }
    }
}
}*/
?>

