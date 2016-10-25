// JavaScript Document
var sendReq = getXmlHttpRequestObject();
var receiveReq = getXmlHttpRequestObject();
var lastMessage = 0;
var mTimer;
function getXmlHttpRequestObject() {
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else if(window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		document.getElementById('p_status').innerHTML = 
		'Status: Cound not create XmlHttpRequest Object.' +
		'Consider upgrading your browser.';
	}
}
function getChatText() {
	if (receiveReq.readyState == 4 || receiveReq.readyState == 0) {
		receiveReq.open("GET", 'getChat.php?chat=1&last=' + lastMessage, true);
		receiveReq.onreadystatechange = handleReceiveChat; 
		receiveReq.send(null);
	}			
}
function handleReceiveChat() {
	if (receiveReq.readyState == 4) {
		var chat_div = document.getElementById('div_chat');
		var xmldoc = receiveReq.responseXML;
		var message_nodes = xmldoc.getElementsByTagName("message"); 
		var n_messages = message_nodes.length
		for (i = 0; i < n_messages; i++) {
			var user_node = message_nodes[i].getElementsByTagName("user");
			var text_node = message_nodes[i].getElementsByTagName("text");
			var time_node = message_nodes[i].getElementsByTagName("time");
			chat_div.innerHTML += user_node[0].firstChild.nodeValue + '&nbsp;';
			chat_div.innerHTML += '<font class="chat_time">' 
			chat_div.innerHTML += time_node[0].firstChild.nodeValue + '</font><br />';
			chat_div.innerHTML += text_node[0].firstChild.nodeValue + '<br />';
			lastMessage = (message_nodes[i].getAttribute('id'));
		}
		mTimer = setTimeout('getChatText();',2000);
	}}
	function sendChatText() {
	if (sendReq.readyState == 4 || sendReq.readyState == 0) {
		sendReq.open("POST", 'getChat.php?chat=1&last=' + lastMessage, true);
		sendReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		sendReq.onreadystatechange = handleSendChat; 
		var param = 'message=' + document.getElementById('txt_message').value;
		param += '&name=Ryan Smith';
		param += '&chat=1';
		sendReq.send(param);
		document.getElementById('txt_message').value = '';
	}							
}
function resetChat() {
	if (sendReq.readyState == 4 || sendReq.readyState == 0) {
		sendReq.open("POST", 'chat/getChat.php?chat=1&last=' + lastMessage, true);
		sendReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		sendReq.onreadystatechange = handleResetChat; 
		var param = 'action=reset';
		sendReq.send(param);
		document.getElementById('txt_message').value = '';
	}							
}
function handleResetChat() {
	document.getElementById('div_chat').innerHTML = '';
	clearInterval(mTimer);
	getChatText();
}
