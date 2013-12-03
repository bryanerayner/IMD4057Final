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
error_reporting(E_ALL);


$message = "";
$buttonText = "Preview Meme";

$top_text = "";
$bottom_text = "";
$image_id = -1;
$filepath = "missing.png";
$textSet = false;
$ip_address = "blank";

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
		if ($_POST["textSet"] == "true")
		{
			$textSet = true;

		}
	}

	if ($textSet)
	{
		//Text was set from last time. Save to database now.
		echo "Saving";
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
			$message = '<div class="success">Successfully added your meme!</div>';
		}else
		{
			$message = '<div class="error">There was a problem adding your meme.</div>';
		}
		
	}



	if (isset($_POST["top-text"]))
	{
		$top_text = $_POST["top-text"];
		$textSet = true;
	}
	if (isset($_POST["bottom-text"]))
	{
		$bottom_text = $_POST["bottom-text"];	
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


	
	$filepath = $meme_image_data["file_name"];
	
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
			
		</section>
		
		<footer class="footer">
			<?php
			include_once("includes/footer.inc.php");
			?>
		</footer>
	</div>
</body>
</html>