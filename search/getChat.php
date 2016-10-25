<?php 
//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
//header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
//header("Cache-Control: no-cache, must-revalidate" ); 
//header("Pragma: no-cache" );
//header("Content-Type: text/xml; charset=utf-8");
 
require('database.php');

if(isset($_POST['message']) && $_POST['message'] != '') {
	$sql = "INSERT INTO message(chat_id, user_id, user_name, message, post_time) VALUES (" . 
			db_input($_GET['chat']) . ", 1, '" . db_input($_POST['name']) . 
			"', '" . db_input($_POST['message']) . "', NOW())";
	db_query($sql);
}

if(isset($_POST['action']) && $_POST['action'] == 'reset') {
	$sql = "DELETE FROM message WHERE chat_id = " . db_input($_GET['chat']);
	db_query($sql);
}

//Create the XML response.
$xml = '<?xml version="1.0" ?><root>';

//Check to ensure the user is in a chat room.
if(!isset($_GET['chat'])) {
	$xml .='Your are not currently in a chat session.  <a href="">Enter a chat session here</a>';
	$xml .= '<message id="0">';
	$xml .= '<user>Admin</user>';
	$xml .= '<text>Your are not currently in a chat session. ';
	$xml .= '&lt;a href=""&gt;Enter a chat session here&lt;/a&gt;</text>';
	$xml .= '<time>' . date('h:i') . '</time>';
	$xml .= '</message>';

} else {
	$last = (isset($_GET['last']) && $_GET['last'] != '') ? $_GET['last'] : 0;
	$sql = "SELECT message_id, user_name, message, date_format(post_time, '%h:%i') as post_time" . 
		" FROM message WHERE chat_id = " . db_input($_GET['chat']) . " AND message_id > " . $last;
	$message_query = db_query($sql);
	while($message_array = db_fetch_array($message_query)) {
		$xml .= '<message id="' . $message_array['message_id'] . '">';
		$xml .= '<user>' . htmlspecialchars($message_array['user_name']) . '</user>';
		$xml .= '<text>' . htmlspecialchars($message_array['message']) . '</text>';
		$xml .= '<time>' . $message_array['post_time'] . '</time>';
		$xml .= '</message>';
	}
}
$xml .= '</root>';
echo $xml;


 

?>
<!doctype html>
<html>
	<head>
		<title>AJAX Driven Web Chat</title>
                <style type="text/css" media="screen">
                overflow: auto; 
height: 300px; 
width: 500px; 
background-color: #CCCCCC; 
border: 1px solid #555555;
                </style>
		<script language="JavaScript" src="js.js" type="text/javascript"></script>
	<script>
    function blockSubmit() {
	sendChatText();
	return false;
}
function startChat() {
	//Set the focus to the Message Box.
	document.getElementById('txt_message').focus();
	//Start Recieving Messages.
	getChatText();
}
    </script>
    </head>


	<body onload="javascript:startChat();">
		<h2>Web Chat.</h2>
		<p id="p_status"></p>
		
		<div id="div_chat" class="chat_main">
			
		</div>
		<form id="frmmain" name="frmmain" onsubmit="return blockSubmit()">
			<input type="button" name="btn_get_chat" id="btn_get_chat" value="Refresh Chat" onclick="javascript:getChatText();"/>
			<input type="button" name="btn_reset_chat" id="btn_reset_chat" value="Reset Chat" onclick="javascript:resetChat();" /><br />
			<input type="text" id="txt_message" name="txt_message" style="width: 447px;" />
			<input type="button" name="btn_send_chat" id="btn_send_chat" onclick="javascript:sendChatText();" value="Send"   />
		</form>
	</body>
	
</html>




