<?php
/**
Accept an mime id and fetch the ip address from the user
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
header("Content-type: application/json");


//check in the likes table to see if there is a match for BOTH the ip address and meme_id
//if not, insert the ip address and meme_id
//Next get the count of rows that match the meme_id
//then output the proper JSON string, formatted like above.

?>