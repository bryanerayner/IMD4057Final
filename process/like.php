<?php
/*
Accept an meme id and fetch the ip address from the user
$_POST['memeid'] will be in the data received

Check in the likes table to see if there is a match for
the pair (image id and ip address).
If there is no match then increment the likes count for the image
in the mtm4057_meme_memes table.

Return a JSON data object that looks like this:

Successful
{"code":0, "msg":"Like recorded", "meme_id":23, "likes":10}

Failures
{"code":100, "msg":"IP address already used to like this Meme.", "meme_id":23}
{"code":200, "msg":"Meme does not exist", "meme_id":23}
{"code":300, "msg":"Unable to record the Like", "meme_id":23}

Notice that all errors have a NON-zero value for code.
**/
session_start();
require_once("../includes/db.inc.php");


header("Content-type: application/json");


//check in the likes table to see if there is a match for BOTH the ip address and meme_id
//if not, insert the ip address and meme_id
//Next get the count of rows that match the meme_id
//then output the proper JSON string, formatted like above.


$meme_id = -1;
$ip_address = "blank";
$output = array("code"=>-1,
	"msg"=>"default",
	"meme_id"=>0,
	"likes"=>0);

if (isset($_SERVER['REMOTE_ADDR']))
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
}



if (isset($_POST['memeid']))
{
	$meme_id = $_POST['memeid'];
}
$output["meme_id"] = $meme_id;
// ip_address = '$ip_address' AND

//Whether or not we will add a like.
$addALike = false;
$alreadyLiked = false;
$dbError = false;




//See if the meme exists
$sql = "SELECT * FROM mtm4057_meme_memes WHERE meme_id = '$meme_id'";

$rs = $pdo->query($sql);




if ($rs)
{
	$rowCount= $rs->rowCount();
	if ($rowCount > 0)
	{
		//Meme exists. Check the likes now.
		$sql = "SELECT * FROM mtm4057_meme_likes WHERE meme_id = '$meme_id'";
		
		$rs = $pdo->query($sql);	
		if ($rs)
		{

			$rowCount= $rs->rowCount();
			
			$output["likes"] = $rowCount;
			if ($rowCount > 0)
			{
				//Iterate through and see if the ip_address is already in there.

				for ($i = 0; $i < $rowCount; $i ++)
				{
					$cRow = $rs->fetch(PDO::FETCH_ASSOC);
					
					
					if ($cRow["ip_address"] == $ip_address)
					{
						$alreadyLiked = true;
						break;
					}
				}
				if (!$alreadyLiked)
				{
					$addALike = true;
				}
			}else
			{
				$addALike = true;
			}
		}else
		{
			$dbError = true;
		}

	}else
	{
		//Meme does not exist
		$output["code"] = 200;
		$output["msg"] = "Meme does not exist";
		unset($output["likes"]);
	}
}else
{
	$dbError = true;
}

if ($alreadyLiked)
{
	//Already liked with this IP
	$output["code"] = 100;
	$output["msg"] = "IP address already used to like this Meme.";
	unset($output["likes"]);
}

if ($addALike)
{
	if ($ip_address == "blank")
	{
	$dbError = true;	
	}else
	{
		$sql = "INSERT INTO mtm4057_meme_likes (ip_address, meme_id) VALUES (?,?)";
	    $rs = $pdo->prepare($sql);
	    
	    $rs->execute(array($ip_address, $meme_id));
	    
	    if ($rs)
	    {
	    	$output["code"] = 0;
	    	$output["msg"] = "Like recorded";

	    	$output["likes"] += 1;
	    }else
	    {
	    	$dbError = true;
	    }
	}
}

if ($dbError)
{
	$output["code"] = 300;
	$output["msg"] = "Unable to record the Like";
	unset($output["likes"]);
}

echo json_encode($output);
exit();

?>