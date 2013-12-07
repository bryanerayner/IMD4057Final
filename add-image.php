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
require_once("includes/db.inc.php");




$message = "";
if (isset($_SERVER["message"]))
{
	$message = $_SERVER["message"];
}

$title = false;
$image_id = false;
$ip_address = "blank";


if (isset($_SERVER['REMOTE_ADDR']))
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
}


if (isset($_POST['btnUpload']))
{

if (isset($_POST['title']))
{
$title = $_POST['title'];
}else
{

$message = '<div class = "error">Missing title - Please resubmit.</div>';
}


$validFile = false;
$feedback = "";
if (isset($_FILES['img']))
{
	if ($title)
	{

		$mime = $_FILES['img']['type'];

		switch( $mime ){
		  case "image/gif":
		    //a gif
		    $ext = ".gif";
		    break;
		  case "image/jpg":
		  case "image/jpeg":
		  case "image/pjpeg":
		    //a jpeg can be several different mime-types
		    $ext = ".jpg";
		    break;
		  case "image/png":
		    //a png image
		    $ext = ".png";
		    break;
		  case "image/webp":
		    //a weppy image
		    $ext = "webp";
		    break;
		  default:
		    //not an image - validation should fail
		    $ext = "";
		} 





		if ($ext != "")
		{
		
			$time = time();
			$rand = uniqid("", true);

			$fileName = $time."_".$rand.$ip_address;
			$fileName = str_replace(":", "", $fileName);
			$fileName = str_replace("/", "", $fileName);
			$fileName = str_replace(".", "_", $fileName);
			$fileName = str_replace("\\", "", $fileName);
			$fileName = str_replace(",", "", $fileName);
			$fileName = str_replace(";", "", $fileName);

			$fileName = $fileName;

			$dir = "images-memes/";

			$ret = move_uploaded_file($_FILES["img"]["tmp_name"], $dir.$fileName.$ext);
			if ($ret)
			{
		        $mime = $_FILES['img']['type'];
		        $filesize = $_FILES["img"]["size"];
		        $sql = "INSERT INTO mtm4057_meme_images (file_name, mime_type, file_size, image_title) VALUES(?,?,?,?)";

		        $rs = $pdo->prepare($sql);
		        $rs->execute(array($fileName, $mime, $filesize, $title));
		        if ($rs)
		        {
		        	$validFile = true;
		        	$_SERVER['message'] = "<div class = \"success\">Successfully uploaded your image!</div>";
		        	$image_id = $pdo->lastInsertId();

		        	$host  = $_SERVER['HTTP_HOST'];
					$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
					$extra = 'add-text.php?image_id='.$image_id;
					header("Location: http://$host$uri/$extra");
					exit;

		        }else
		        {
		        	$feedback = "Error with saving the file in database.";
		        }
			}else
			{
				$feedback = "Error with moving the uploaded file to ".$dir.$fileName;

			}
		}else
		{
			$feedback = "That was not an image file. MIME Type was $mime";
		}
	}
}

if (!$validFile)
{
$message = '<div class = "error">There was an error with the file upload. '.$feedback.'</div>';
}



}
if (!$title)
{
	unset($title);
}
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
			echo $message;
			if ($validFile):
			?>
			<a href = "add-text.php?image_id=<?php echo $image_id;?>">Add text to your image.</a>
			<?php
			endif;
			//display feedback about the image being uploaded successfully here
			//if the image was uploaded successfully then display a link to the add-text page too.
			
			?>
			<form name="addImage" action="add-image.php" method="post" enctype="multipart/form-data">
				<div class="formbox">
					<label for="title">Meme Title</label>
					<input type="text" name="title" id="title" value="" placeholder="title" <?php if (isset($title)) {echo "value=\"$title\"";}?>/>
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