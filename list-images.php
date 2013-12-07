<?php
/*********************************
List Images page displays all the current 
images from the database WITHOUT any
text

After the user selects an image
then the page should send the user
to the create-meme.php page

image_id is to be sent through 
$_GET or $_SESSION
*********************************/
session_start();
require_once("includes/db.inc.php");
require_once("includes/image.inc.php");
require_once("includes/mime.inc.php");


$images = false;
//Fetch memes
$sql = $sql_query_image." ORDER BY image_title ASC";

$images_query = $pdo->query($sql);

if ($images_query)
{
	$images = array();
	$count = $images_query->rowCount();

	for ($i = 0; $i < $count; $i++)
	{
		$temp = $images_query->fetch(PDO::FETCH_ASSOC);
		$temp["ext"] = mimeTypeToExt($temp["mime_type"]);
		$images[] = $temp;
	}
}

$message = "";

if (isset($_SERVER["message"]))
{
	$message = $_SERVER["message"];
}

?><!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Meme List - Meme Generator</title>
	<?php
	include_once( "includes/scripts.inc.php");
	?>
</head>

<body>
	<div class="wrapper">
		<header class="masthead">
			<?php
			include_once("includes/masthead.inc.php");
			?>
		</header>
		
		<nav class="nav" role="navigation">
			<?php
			include_once("includes/nav.inc.php");
			?>	
		</nav>
		
		<section class="main">
			<h2>Choose an Image to Make a Meme</h2>
			<?php
			//the list below to be generated by PHP
			//by selecting the list of images from the database
			?>
			<ul class="memes clearfix">
				<?php

					if ($images):


					$i = 0;
					$count = count($images);

					for ($i = 0; $i < $count; $i++):
				?>
				<li>
					<a href="add-text.php?image_id=<?php echo urlencode($images[$i]['image_id']);?>">
						<?php echo imageTag($images[$i]);?><span class = "list">Add Text to this image</span>
						<h3><?php echo $images[$i]['image_title'];?></h3>
					</a>
				</li>
				<?php
					endfor;

					endif;
				?>
				
			</ul>
				
		</section>
		
		<footer class="footer">
			<?php
			include_once("includes/footer.inc.php");
			?>
		</footer>
	</div>
</body>
</html>