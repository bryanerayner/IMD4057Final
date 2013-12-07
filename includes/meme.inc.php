<?php 




function memeTag($meme)
{
	return "<img src=\"img/image.php?imagePath=".urlencode($meme['file_name']).urlencode($meme["ext"])."&top-text=".urlencode($meme['top_text'])."&bottom-text=".urlencode($meme['bottom_text'])."\" alt=\"meme image\" />";
}


$sql_query_meme = "SELECT memes.*, images.file_name, images.mime_type, images.file_size, images.file_size FROM mtm4057_meme_memes as memes INNER JOIN mtm4057_meme_images as images ON memes.image_id = images.image_id";

?>