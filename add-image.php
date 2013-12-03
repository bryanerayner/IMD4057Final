<?php
/*********************************
Add Image page allows the user to
add a new image to the database
Do all the image processing at the top

After the user saves a new image
then the page should display a link
to the create-meme.php page

New image_id is to be sent through
$_GET or $_SESSION
*********************************/
session_start();


?><!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Upload - Meme Generator</title>
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
			<h2>Upload a New Image to Start a Meme</h2>
			<?php
			//display feedback about the image being uploaded successfully here
			//if the image was uploaded successfully then display a link to the add-text page too.
			
			?>
			<form name="addImage" action="add-image.php" method="post" enctype="multipart/form-data">
				<div class="formbox">
					<label for="title">Meme Title</label>
					<input type="text" name="title" id="title" value="" placeholder="title" />
				</div>
				<div class="formbox">
					<label for="img">Image</label>
					<input type="file" name="img" id="img" />
				</div>
				<div class="formbox buttons">
					<input type="submit" name="btnUpload" id="btnUpload" value="Upload" />
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