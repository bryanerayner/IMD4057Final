// JavaScript Document

$(document).ready(init);

function init(){
	//script to run when page loads
	
	//If there are anchors/spans with the className "like"
	//then add the click handler
	$(".like").click( submitLike );	
	
}

function submitLike(ev){
	var meme_id = $(this).id;
	meme_id = meme_id.replace("meme_","");
	$.ajax({
		url: 'process/like.php',
		data: 'memeid=' + meme_id,
		dataType:"json",
		type:'POST'
	}).done( gotReply ).fail( badStuff );
}

function gotReply( data ){
	/**********************************************
	runs with a successful fetch of the JSON file
	successful data object would look like this
	{"code":0, "msg":"Like recorded", "meme_id":23, "likes":12}
	Need to get the number of likes from the 
	JSON and update the span with the count.
	If code is not zero then display the error message.
	************************************************/
	var code = data.code;
	var meme_id = data.meme_id;
	var msg = data.msg;
	switch(code){
		case 0:
			//update the like count
			var likeCount = data.likes;
			//This will add the count of likes into an element with the CSS classname "likes"
			//which is inside of an element with the id "meme_##"
			$("#meme_" + meme_id).siblings(".likes").text(likeCount);
			break;
		case 100:
			alert( msg );
			break;
		case 200:
			alert( msg );
			break;
		case 300:
			alert( msg );
		 	break;
		case 400:
			alert( msg );
			break;
	}
}

function badStuff( jqxhr, status, error ){
	//runs if the AJAX call fails
	//display a message about the failure
	alert("Sorry. Unable to register your like.");
}

