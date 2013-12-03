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
			//if the form is uploaded and the image text is saved then
			//display the image with the text here just to show that it worked.
			
			?>
			<form name="memeForm" action="add-text.php" method="post">
				<div class="formbox">
					<label for="top-text">Top Text</label>
					<input type="text" name="top-text" id="top-text" placeholder="top text" />
				</div>
				<img src="images-memes/missing.png" alt="meme image" />
				<div class="formbox">
					<label for="bottom-text">Bottom Text</label>
					<input type="text" name="bottom-text" id="bottom-text" placeholder="bottom text" />
				</div>
				<div class="formbox buttons">
					<input type="submit" name="btnSubmit" id="btnSubmit" value="Create Meme" />
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