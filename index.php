<?php
/*********************************
Home page fetches a list of the newest memes
and displays up to 12 of them
$_SESSION variable determines whether to sort the
list based on age of meme or most liked.
*********************************/
session_start();

require_once("includes/db.inc.php");


if (!isset($_SESSION["SortType"]))
{
	$_SESSION["SortType"] = "most_liked";
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
			<h2>Today's Top Memes</h2>
			
			<ul class="memes">
				<li>
					<img src="images-memes/missing.png" alt="meme image" />
					<span class="icon like" id="meme_123">Like</span><span class="likes">0</span>
					<time datetime="2013-11-11">11 Nov, 2013</time>
				</li>
				<li>
					<img src="images-memes/missing.png" alt="meme image" />
					<span class="icon like" id="meme_125">Like</span><span class="likes">0</span>
					<time datetime="2013-11-11">11 Nov, 2013</time>
				</li>
				<li>
					<img src="images-memes/missing.png" alt="meme image" />
					<span class="icon like" id="meme_127">Like</span><span class="likes">0</span>
					<time datetime="2013-11-11">11 Nov, 2013</time>
				</li>
				<li>
					<img src="images-memes/missing.png" alt="meme image" />
					<span class="icon like" id="meme_129">Like</span><span class="likes">0</span>
					<time datetime="2013-11-11">11 Nov, 2013</time>
				</li>
				<li>
					<img src="images-memes/missing.png" alt="meme image" />
					<span class="icon like" id="meme_131">Like</span><span class="likes">0</span>
					<time datetime="2013-11-11">11 Nov, 2013</time>
				</li>
				<li>
					<img src="images-memes/missing.png" alt="meme image" />
					<span class="icon like" id="meme_133">Like</span><span class="likes">0</span>
					<time datetime="2013-11-11">11 Nov, 2013</time>
				</li>
				<li>
					<img src="images-memes/missing.png" alt="meme image" />
					<span class="icon like" id="meme_135">Like</span><span class="likes">0</span>
					<time datetime="2013-11-11">11 Nov, 2013</time>
				</li>
				<li>
					<img src="images-memes/missing.png" alt="meme image" />
					<span class="icon like" id="meme_137">Like</span><span class="likes">0</span>
					<time datetime="2013-11-11">11 Nov, 2013</time>
				</li>
				<li>
					<img src="images-memes/missing.png" alt="meme image" />
					<span class="icon like" id="meme_138">Like</span><span class="likes">0</span>
					<time datetime="2013-11-11">11 Nov, 2013</time>
				</li>
				<li>
					<img src="images-memes/missing.png" alt="meme image" />
					<span class="icon like" id="meme_139">Like</span><span class="likes">0</span>
					<time datetime="2013-11-11">11 Nov, 2013</time>
				</li>
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