<?php
require('../vendor/autoload.php');
use Intervention\Image\ImageManagerStatic as Image;
$image_name 	= __DIR__ . '/../assets/img/folio.jpg';
$font_name 		= __DIR__ . '/../assets/font/my_handwriting/My_handwriting.ttf';
$random 		= 'hasil-'.time().'-'.rand(100,999);
$export_name 	= __DIR__ . '/../output/'.$random.'.jpg';
$width       	= 600;
$height      	= 800;
$center_x    	= $width / 2;
$center_x 		= 55;
$center_y    	= 96;
$max_len     	= 78;
$font_size   	= 25;
$font_height 	= 19;
$text 			= $_REQUEST['text'];
$lines 			= explode("\n", wordwrap($text, $max_len));
$y     			= $center_y - ((count($lines) - 1) * $font_height);
$y 				= ($y < $center_y) ? $y+($center_y-($y)) : $y;
$count 			= (count($lines) > 39) ? 39 : count($lines);
$img 			= Image::make($image_name);
for($i=0; $i < $count; $i++){ 
	$img->text($lines[$i], $center_x, $y, function($font){
		global $font_size;
		global $font_name;
		$font->file($font_name);
	    $font->size($font_size);
		$font->color('#000000');
		$font->align('left');
	});
	//echo $i.". ".$center_x.", ".$y." ".$font_height." => ".$lines[$i]."<br>";
	$font_height = ($i == 4) ? $font_height-1 : $font_height;
	$font_height = ($i == 5) ? $font_height-2 : $font_height;
	$font_height = ($i == 6) ? $font_height+1 : $font_height;
	$y += $font_height * 1;
}
$img->save($export_name);
echo $random;