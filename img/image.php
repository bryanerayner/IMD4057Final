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

$filename = "../images-memes/missing.png";

$topText = "";
$bottomText = "";


if (isset($_GET["imagePath"]))
{
	$filename = "../images-memes/".$_GET["imagePath"];
}

if (isset($_GET["top-text"]))
{
	$topText = $_GET["top-text"];
}
if (isset($_GET["bottom-text"]))
{
	$bottomText = $_GET["bottom-text"];
}


$image = false;



$imageInfo = getimagesize($filename);



switch ($imageInfo["mime"])
{
	case "image/gif":
		//a gif
		$image = imagecreatefromgif($filename);
		break;
	case "image/jpg":
	case "image/jpeg":
	case "image/pjpeg":
		$image = imagecreatefromjpeg($filename);
		break;
	case "image/png":
		//a png image
		$image = imagecreatefrompng($filename);
		break;
	case "image/webp":
		//a weppy image
		$image = imagecreatefromwebp($filename);
		break;
	default:
		//not an image - validation should fail
		$ext = "";
}


if ($image)
{
	header("Content-Type: ".$imageInfo['mime']);

	//SoMETHING HAS CHANGED HERE!!!
	


	$w = $imageInfo[0];
	$h = $imageInfo[1];

	$topWords = imageCreate($w, 40);
	$t = scaleText($topText, $w, $topWords);
	$bottomWords = imageCreate($w, 40);
	$b = scaleText($bottomText, $w, $bottomWords);

	$font = "arial.ttf";
	$angle = 0;
	
	imagefttext($t['img'], $t['fontsize'], $angle, 5, ($t['fontsize'] + 5), $t['color'], $font, $t['msg']);
	//add the top text image to the image which will be returned
	imageCopy($image, $t['img'], 0, 0, 0, 0, imagesx($t['img']), imagesy($t['img']) );

	//bottom text added to the bottom text image
	imagefttext($b['img'], $b['fontsize'], $angle, 5, ($b['fontsize'] + 5), $b['color'], $font, $b['msg']);
	//add the bottom text image to the image which will be returned
	imageCopy($image, $b['img'], 0, ($h-40), 0, 0, imagesx($b['img']), imagesy($b['img']) );


	switch ($imageInfo["mime"])
	{
		case "image/gif":
			//a gif
			imagegif($image);
			exit();
			break;
		case "image/jpg":
		case "image/jpeg":
		case "image/pjpeg":
			imagejpeg($image);
			exit();
			break;
		case "image/png":
			//a png image
			imagepng($image);
			exit();
			break;
		case "image/webp":
			//a weppy image
			imagewebp($image);
			exit();
			break;
	}
}




?>