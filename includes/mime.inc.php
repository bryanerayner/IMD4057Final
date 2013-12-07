<?php

function mimeTypeToExt($mime)
{
	switch( $mime ){
		  case "image/gif":
		    //a gif
		    return ".gif";
		    break;
		  case "image/jpg":
		  case "image/jpeg":
		  case "image/pjpeg":
		    //a jpeg can be several different mime-types
		    return ".jpg";
		    break;
		  case "image/png":
		    //a png image
		    return ".png";
		    break;
		  case "image/webp":
		    //a weppy image
		    return ".webp";
		    break;
		  default:
		    //not an image - validation should fail
		    return "";
		} 
		return false;
}


?>