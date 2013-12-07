<?php
 

/*********************************
Add text page takes the image_id 
from the $_GET or $_SESSION array

Then fetch the info from the database
based on the image id.

let the users enter text and then 
save that text associated with the image.
When the page reloads after saving the text
it should display a sample of the image
with the text added to the top and bottom.

Make sure you scale the text to cover a reasonable 
amount of space at the top and bottom.
Set a font-size appropriate for the 
amount of text and the size of the image.
*********************************/
session_start();
require_once("includes/db.inc.php");
require_once("includes/mime.inc.php");



error_reporting(E_ALL);




$message = "";


if (isset($_SERVER["message"]))
{
	$message = $_SERVER["message"];
}

$buttonText = "Preview Meme";

$top_text = "";
$bottom_text = "";
$image_id = -1;
$filepath = "missing.png";
$textSet = false;

$ip_address = "blank";

if (isset($_SERVER['REMOTE_ADDR']))
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
}

if (isset($_GET["image_id"]))
{
	$image_id = $_GET["image_id"];
	$_SESSION["image_id"] = $image_id;
}else if (isset($_SESSION["image_id"]))
{
	$image_id = $_SESSION["image_id"];
}


if (isset($_POST["btnSubmit"]))
{
	if (isset($_POST["textSet"]))
	{
		if ($_POST["textSet"] == "1" || $_POST["textSet"] == "true")
		{
			$textSet = true;

			if (isset($_POST["top-text"]))
			{
				if ($_SESSION["top-text"] != $_POST["top-text"])
				{
					$textSet = false;
				}
			}
			if (isset($_POST["bottom-text"]))
			{
				if ($_SESSION["bottom-text"] != $_POST["bottom-text"])
				{
					$textSet = false;
				}
			}
		}
	}
	

	if ($textSet)
	{
		//Text was set from last time. Save to database now.
		
		if (isset($_POST["top-text"]))
		{
			$top_text = $_POST["top-text"];	
			
		}
		if (isset($_POST["bottom-text"]))
		{
			$bottom_text = $_POST["bottom-text"];	
			
		}		

		$sql = "INSERT INTO  `mtm4057_meme_memes` (  `image_id` ,  `top_text` ,  `bottom_text` ,  `ip_address`) VALUES ( '".$image_id."',  '".$top_text."',  '".$bottom_text."',  '".$ip_address."' )";
		
		$rows = $pdo->query($sql);
		if ($rows)
		{
			$_SERVER['message'] = '<div class="success">Successfully added your meme!</div>';

			//Reset to as if nothing had been submitted.
			$textSet = false;
			unset($_POST["top-text"]);
			unset($_POST["bottom-text"]);
			$top_text = "";
			$bottom_text = "";
			unset($_SESSION["image_id"]);
			$image_id = -1;

			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'index.php';
			header("Location: http://$host$uri/$extra");
			exit;


		}else
		{
			$message = '<div class="error">There was a problem adding your meme. Try resubmitting the form.</div>';
		}
		
	}



	if (isset($_POST["top-text"]))
	{
		$top_text = $_POST["top-text"];
		$_SESSION["top-text"] = $top_text;
		$textSet = true;
	}
	if (isset($_POST["bottom-text"]))
	{
		$bottom_text = $_POST["bottom-text"];	
		$_SESSION["bottom-text"] = $bottom_text;
		$textSet = true;
	}

	if ($textSet)
	{
		$buttonText = "Create Meme";
	}
}



$sql = "SELECT * FROM mtm4057_meme_images WHERE image_id = '$image_id'";

$meme_image = $pdo->query($sql);


if ($meme_image)
{
	$meme_image_data = $meme_image->fetch(PDO::FETCH_ASSOC);


	
	$filepath = $meme_image_data["file_name"].mimeTypeToExt($meme_image_data["mime_type"]);

}
else
{
	  
}






?><!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Create A Meme - Meme Generator</title>
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
			<h2>Add Your Text to the Meme Image</h2>

			<?php
			echo $message;
			//if the form is uploaded and the image text is saved then
			//display the image with the text here just to show that it worked.
			if ($image_id > 0):
			?>
			<form name="memeForm" action="add-text.php" method="post">
				<input type="hidden" name = "textSet" id = "textSet" value = "<?php echo $textSet;?>">
				<div class="formbox">
					<label for="top-text">Top Text</label>
					<input type="text" name="top-text" id="top-text" placeholder="top text" <?php if ($textSet) { echo "value=\"$top_text\"";} ?>  />
				</div>
				<img src="<?php echo "img/image.php?imagePath=".urlencode($filepath)."&top-text=".urlencode($top_text)."&bottom-text=".urlencode($bottom_text); ?>" alt="meme image" />
				<div class="formbox">
					<label for="bottom-text">Bottom Text</label>
					<input type="text" name="bottom-text" id="bottom-text" placeholder="bottom text" <?php if ($textSet) { echo "value=\"$bottom_text\"";} ?> />
				</div>
				<div class="formbox buttons">
					<input type="submit" name="btnSubmit" id="btnSubmit" value="<?php echo $buttonText;?>" />
				</div>
			</form>
			<?php
			else:
			?>
			<a href = "list-images.php">Choose a new image to add text.</a>

			<?php 
			endif;
			?>
			
		</section>
		
		<footer class="footer">
			<?php
			include_once("includes/footer.inc.php");
			?>
		</footer>
	</div>
</body>
</html>