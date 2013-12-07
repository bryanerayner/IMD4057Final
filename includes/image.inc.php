<?php 




function imageTag($image)
{
	return "<img src=\"images-memes/".$image['file_name'].$image['ext']."\" alt=\"".$image['image_title']."\" />";
}



$sql_query_image = "SELECT * FROM mtm4057_meme_images ";

?>