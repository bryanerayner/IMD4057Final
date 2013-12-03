<?php
//image.php
function scaleText( $msg, $w, $txtImg ){
	$words = explode(" ", $msg);
	$fontsize = 12;
	$numwords = sizeof($words);
	if($numwords > 4){
		$firstLine = $words[0] . " " . $words[1] . " " . $words[2] . " " . $words[3] . "\r\n";
		$secondLine = "";
		for($i=4; $i<$numwords; $i++){
			$secondLine .= $words[$i] . " ";	
		}
		$longerline = max( array(strlen($firstLine), strlen($secondLine) ));
		$pixelPer = $w / $longerline; //get pixels per letter.
		$fontsize = 1.4 * $pixelPer;
		$msg = $firstLine . $secondLine;
	}else{
		$pixelPer = $w / strlen($msg); //get pixels per letter.
		$fontsize = 1.4 * $pixelPer;
	}
	
	$bg = imageColorAllocateAlpha($txtImg, 0, 0, 0, 127); //transparent
	$color = imageColorAllocate($txtImg, 255, 255, 255);	//white
	
	return array("msg"=>$msg, "fontsize"=>$fontsize, "color"=>$color, "img"=>$txtImg);
}



//take image_id from $_REQUEST['iid'] instead of hard coding image
$filename = "./insanity-wolf.jpg";

//set the header for the type of image
header("Content-Type: image/jpg");

//if we want the width, height, to calculate sizes and positioning.
list($width, $height) = getimagesize($filename);

//create the base image
$img = imagecreatefromjpeg( $filename );

//check the querystring
if( isset($_GET['top']) && !empty($_GET['top'])){
	$topMsg = ($_GET['top']);	
}else{
	$topMsg = "Default Top Text";	
}

if( isset($_GET['bot']) && !empty($_GET['bot'])){
	$bottomMsg = trim($_GET['bot']);	
}else{
	$bottomMsg = "Default Bottom Text";
}

//create an image to hold the text on top
$msgTopImg = imageCreate($width, 40);
$t = scaleText($topMsg, $width, $msgTopImg);

//create an image to hold the text on bottom
$msgBottomImg = imageCreate($width, 40);
$b = scaleText($bottomMsg, $width, $msgBottomImg);

$font="Arial.ttf";	//this font is in this folder
$angle = 0;

//top text added to the top text image
imagefttext($t['img'], $t['fontsize'], $angle, 5, ($t['fontsize'] + 5), $t['color'], $font, $t['msg']);
//add the top text image to the image which will be returned
imageCopy($img, $t['img'], 0, 0, 0, 0, imagesx($t['img']), imagesy($t['img']) );

//bottom text added to the bottom text image
imagefttext($b['img'], $b['fontsize'], $angle, 5, ($b['fontsize'] + 5), $b['color'], $font, $b['msg']);
//add the bottom text image to the image which will be returned
imageCopy($img, $b['img'], 0, ($height-40), 0, 0, imagesx($b['img']), imagesy($b['img']) );

//output the image
imagejpeg($img);
exit();
?>