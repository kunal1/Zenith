<?php

// put your code here
session_start();

include_once './memberMasterPage.php';
require_once '../userInfoDB.php';
include_once './userPM.php';

// note for me(jassi): make the following code querystring based
//$_SESSION['loginUserId'] = 4;
//$_SESSION['userFName'] = "Tunde";

if (!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])) {
    header('Location: ../Login.aspx');
}

if (isset($_GET["searchUserId"])) {
    $searchUserId = $_GET["searchUserId"]; // THIS WILL BE THE VALUE FROM QUERYSTRING
} else {
    $searchUserId = $_SESSION['loginUserId'];
    //this line of code is used to replace line 40 to 46 to avoid error
    $personalAcc = true;
      if (isset($_GET['actEdit'])) {
       $act = $_GET['actEdit'];
   }
}


// ==================================== THIS CODE IS MUST  (START) ==============================================
$objPage = new memberMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
$objPage->setTitle('Zenith - Members Private Messaging');
$objPage->setMetaAuthor('Tunde Obatayo');
// ==================================== THIS CODE IS MUST  (END) ==============================================

$objUsers = new userInfoDB();

$personalAcc = false;
$act = '';

$recdetail = new userPM();
$recdetails = $recdetail ->getReceiver();

//if ($searchUserId == $_SESSION['loginUserId']) {
//    $personalAcc = true;
//
//    if (isset($_GET['actEdit'])) {
//        $act = $_GET['actEdit'];
//    }
//}

$body = '<form class="form-horizontal" action="memberinbox.php" method="post" name="successform">';
$body .= '<fieldset>';
//Form Name -->
$body .= '<legend>Send Private Message</legend>';
//display response message if not empty
if(!empty($rmsg)){
$body .= "<p style='color:#FF0'>$rmsg</p>";
}
//Text input
$body .= '<div class="form-group">';
$body .= '<label class="col-md-4 control-label" for="title">Title: </label>';
$body .= '<div class="col-md-8">';
$body .= '<input id="title" name="title" class="form-control input-md" required type="text">';
$body .= '</div>';
$body .= '</div>';
//Text input
//this variable should be auto filled
$body .= '<div class="form-group">';
$body .= '<label class="col-md-6 control-label" for="receiver">Recipient: </label>';
$body .= '<div class="col-md-6">';

$body .= '<select name="receiver">';
foreach($recdetails as $recdetail):
	$receiverid = $recdetail['userId'];
	$rname = $recdetail['userName'];
$body .= '<option value="'. $receiverid .'">'. $rname .'</option>';
endforeach;
$body .= '</select>';
$body .= '<input name="stage" type="hidden" value="sendpm">';
$body .= '</div>';
$body .= '</div>';

//Textarea 
$body .= '<div class="form-group">';
$body .= '<label class="control-label" for="message" pull left>Enter Your Message: </label><br/>';
$body .= '<div class="col-md-12">';
$body .= '<textarea class="form-control" id="message" name="message" required></textarea>';
$body .= '<span class="help-block">Enter your message(max 500 characters)</span>';
$body .= '</div>';
$body .= '</div>';
//Submit Button 
$body .= '<div class="form-group">';
$body .= '<label class="col-md-8 control-label" for="userpm"></label>';
$body .= '<div class="col-md-4">';
$body .= '<button id="subStory" name="userpm" class="btn btn-success">Submit</button>';
$body .= '</div>';
$body .= '</div>';
$body .= '</fieldset>';
$body .= '</form>';

$objPage->displayPage($body);
?>        