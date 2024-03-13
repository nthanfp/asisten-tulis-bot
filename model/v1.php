<?php
require('../vendor/autoload.php');

use Intervention\Image\ImageManagerStatic as Image;

$image_name 	= __DIR__ . '/../assets/img/kertas-buku2.jpg';
// echo file_get_contents($image_name);
$font_name 		= __DIR__ . '/../assets/font/my_handwriting/My_handwriting.ttf';
$random 		= 'hasil-' . time() . '-' . rand(100, 999);
$export_name 	= __DIR__ . '/../output/' . $random . '.jpg';
$width       	= 600;
$height      	= 800;
$center_x    	= $width / 2;
$center_x 		= 127;
$center_y    	= 90;
$max_len     	= 72;
$font_size   	= 25;
$font_height 	= 21;
$text 			= $_REQUEST['text'];
$lines 			= explode("\n", wordwrap($text, $max_len));
$y     			= $center_y - ((count($lines) - 1) * $font_height);
$y 				= ($y < $center_y) ? $y + ($center_y - ($y)) : $y;
$count 			= (count($lines) > 31) ? 31 : count($lines);
$img 			= Image::make($image_name);
for ($i = 0; $i < $count; $i++) {
	$img->text($lines[$i], $center_x, $y, function ($font) {
		global $font_size;
		global $font_name;
		$font->file($font_name);
		$font->size($font_size);
		$font->color('#000000');
		$font->align('left');
	});
	//echo $i.". ".$center_x.", ".$y." ".$font_height." => ".$lines[$i]."<br>";
	$font_height = ($i == 7) ? $font_height + 1 : $font_height;
	$font_height = ($i == 9) ? $font_height - 1 : $font_height;
	$font_height = ($i == 23) ? $font_height + 1 : $font_height;
	$y += $font_height * 1;
}
$img->text(date('d-m-Y'), 455, 45, function ($font) {
	global $font_size;
	global $font_name;
	$font->file($font_name);
	$font->size($font_size);
	$font->color('#000000');
	$font->align('left');
});
$img->save($export_name);
echo $random;
