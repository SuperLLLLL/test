<?php
	header("Content-Type:text/html;charset=utf-8");
	$search_music = urlencode("夜空中最亮的星");
	$plat = "yiting_spider";
	$py_exe = "D:/software/python3.7/python.exe " . "F:/website/" . $plat . ".py ";
	$out = exec($py_exe . " {$search_music}",$output);
	echo var_dump($out);
	foreach($output as $key => $value){
		echo var_dump(json_decode($value))."<br />";
    	}
?>