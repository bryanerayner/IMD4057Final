<?php
/*********************************
Home page fetches a list of the newest memes
and displays up to 12 of them
$_SESSION variable determines whether to sort the
list based on age of meme or most liked.
*********************************/

session_start();

require_once("includes/db.inc.php");
require_once("includes/meme.inc.php");
require_once("includes/mime.inc.php");


if (!isset($_SESSION["SortType"]))
{
	$_SESSION["SortType"] = "most_liked";
}
$message = "";
if (isset($_SERVER["message"]))
{
	$message = $_SERVER["message"];
}

$memes = false;
$likes = false;

$memesIn = 'IN(';
	
//Fetch memes
$sql = $sql_query_meme." ORDER BY memes.created DESC LIMIT 12";

$memes_query = $pdo->query($sql);

if ($memes_query)
{
	$memes = array();
	$count = $memes_query->rowCount();

	for ($i = 0; $i < $count; $i++)
	{
		$temp = $memes_query->fetch(PDO::FETCH_ASSOC);
		$temp["ext"] = mimeTypeToExt($temp["mime_type"]);
		
		$memes[] = $temp;
		
		if ($i == $count-1)
		{
			$memesIn = $memesIn."'".$memes[$i]['meme_id']."')";
		}else
		{
			$memesIn = $memesIn."'".$memes[$i]['meme_id']."', ";
		}
	}
}

$ip_address = "blank";
if (isset($_SERVER['REMOTE_ADDR']))
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
}


if ($memes)
{
	$sql = "SELECT * FROM mtm4057_meme_likes WHERE meme_id ".$memesIn;
	
	$likes_query = $pdo->query($sql);

	if ($likes_query)
	{
		$likes_temp = array();
		$likes = array();
		$count = $likes_query->rowCount();

		for ($i = 0; $i < $count; $i++)
		{
			$likes_temp[] = $likes_query->fetch(PDO::FETCH_ASSOC);
		}
		

		for ($i = 0; $i < $count; $i++)
		{
			
			
			if (isset($likes[$likes_temp[$i]['meme_id']]))
			{
				$likes[$likes_temp[$i]['meme_id']]['count'] += 1;

			}else
			{
				$likes[$likes_temp[$i]['meme_id']] = $likes_temp[$i];
				$likes[$likes_temp[$i]['meme_id']]['count'] = 1;
			}
			if ($likes[$likes_temp[$i]['meme_id']]['ip_address'] == $ip_address)
			{
				$likes[$likes_temp[$i]['meme_id']]['liked'] = true;
			}
		}
	}
}


?><!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Home - Meme Generator</title>
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
			<?php
			echo $message;
			?>
			<h2>Today's Top Memes</h2>
				

				<?php 
				if (!empty($message)):
				?>
				<p><?php echo $message; ?></p>
				<?php
				endif;
				?>
			<ul class="memes fixLayout clearfix">


				<?php 
					
					if ($memes):


					$i = 0;
					$count = count($memes);

					for ($i = 0; $i < $count; $i++):
				?>

					<li>
						<?php echo memeTag($memes[$i]);?>
						<div class = "like_group">
							<span class="icon like" id="meme_<?php 
							echo $memes[$i]['meme_id'];
							?>"><?php 
							if (isset($likes[$memes[$i]['meme_id']]))
								{
									echo (isset($likes[$memes[$i]['meme_id']]['liked']))?"Liked":"Like" ;
								}else{
									echo "Like";
								}?></span><span class="likes"><?php 
								if (isset($likes[$memes[$i]['meme_id']]))
									{
										echo $likes[$memes[$i]['meme_id']]['count'];
									}else{
										echo "0";
									}?></span>
							<time datetime="<?php echo $memes[$i]['created']; ?>"><?php echo date("F j, Y, g:i a",strtotime($memes[$i]['created'])); ?></time>
						</div>
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