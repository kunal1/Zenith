<?php
// put your code here
session_start();
include_once 'memberMasterPage.php';
require_once '../userInfoDB.php';
require_once '../Database.php';
require_once 'userPM.php';

$success = '';
$error = '';

$logged_uid = isset($_SESSION['loginUserId']) ? $_SESSION['loginUserId'] : 0;
$userpm = new userPM(); //instantiate the class

if(isset($_GET['msgid']) && $_GET['msgid'] <> 0){
    $currentMsg = $userpm->GetMessage($_GET['msgid']);
    $userpm->MarkAsRead($_GET['msgid']);
}
if (isset($_POST['stage'])) {//check if a form is posted
    switch ($_POST['stage']) {
        case 'sendpm'://if it is the send pm form
            
            //collect info from pm form
            $pmtitle = $_POST['title'];
            $pmreceiver = $_POST['receiver'];
            $pmmsg = $_POST['message'];
            $pmsubdate = date('Y-m-d H:m:i'); //current datetime
            $pmsender = $logged_uid; //this will be fetched from the session

            if (!empty($pmmsg) && !empty($pmtitle)) {
                $code = $userpm->SendMessage($pmtitle, $pmmsg, $pmsender, $pmreceiver);
                if ($code == 0) {
                    $success = 'Message Sent Successfully';
                } else {
                    $error = "Message Not Sent. error code:" . $code;
                }
            } else {
                $error = "Title and Message field can not be blank";
            }
            
            if(!empty($error))
                header ('Location: ./memberpmsend.php');
            break;
    }
}
// note for me(jassi): make the following code querystring based
//$_SESSION['loginUserId'] = 4;
//$_SESSION['userFName'] = "Tunde";

if (!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])) {
    header('Location: ../login.php');
}

if (isset($_GET["searchUserId"])) {
    $searchUserId = $_GET["searchUserId"]; // THIS WILL BE THE VALUE FROM QUERYSTRING
} else {
    $searchUserId = $_SESSION['loginUserId'];
}


// ==================================== THIS CODE IS MUST  (START) ==============================================
$objPage = new memberMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
$objPage->setTitle('Zenith - User Private Message Update');
$objPage->setMetaAuthor('Tunde Obatayo');
// ==================================== THIS CODE IS MUST  (END) ==============================================

//$body = "<form class='form-horizontal' method='post'>";
//$body .="<h1>Private Message Submission</h1>";
//$body .= "<p> $success </p>";
//$body .= "<p> $error </p>";
//$body .="</form>";
$recdetail = new userPM();
$recdetails = $recdetail ->gettheReceiver();

ob_start();
if(!empty($success)){?>
<p style="color: #F00;"><?php  echo $success;  ?></p>
<?php } ?>

<h2>Private Messages</h2>
<?php if(isset($currentMsg) && !empty($currentMsg)){ ?>
<div style="border: solid 1px #ccc;">
<?php 
foreach($recdetails as $recdetail):
    $rname = $recdetail['userName'];?>
    <h3>Sender : <?php echo $rname; ?></h3>
    <hr/>
<?php    endforeach;?>
    <p style="padding: 10px;">
        <?php echo $currentMsg['body']; ?>
    </p>
</div>
<?php } ?>
<h4>Inbox</h4>
<div>
   <?php $inbox = $userpm->getAll(0,0,$logged_uid); 
   if(!empty($inbox)){ ?>
    <table class="table-striped table-bordered">
        <thead>
            <tr>
        <th>Sender</th>
        <th>Message</th>
        <th>Read</th>
        <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($inbox as $msg){ ?>
            <tr>
                <td><?php echo $msg['sender'];//convert this to the username ?></td>
                <td><?php echo substr($msg['body'], 0,40).'...';//summary of message... first 20 characters ?></td>
                <td><?php echo $msg['read'] == 1 ? 'Yes' : 'No'; ?></td>
                <td><a href="memberinbox.php?msgid=<?php echo $msg['idMsg'];  ?>">View Message</a></td>
            </tr>  
            
            <?php }  ?>
        </tbody>
    </table> 
 <?php  }else{
       echo '<strong>No Message</strong>';
   }
   ?>
    
</div>
<div style="clear: both; height: 20px;"></div>

<h4>Sent</h4>
<div>
   <?php $sent = $userpm->getAll(0,$logged_uid); 
   if(!empty($sent)){ ?>
    <table class="table-striped table-bordered" >
        <thead>
            <tr>
        <th>Receiver</th>
        <th>Message</th>
        <th>Read</th>
        <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($sent as $sentmsg): ?>
            <tr>
                <td><?php echo $sentmsg['receiver'];//convert this to the username ?></td>
                <td><?php echo substr($sentmsg['body'], 0,20).'...';//summary of message... first 20 characters ?></td>
               <td><?php echo $sentmsg['read'] == 1 ? 'Yes' : 'No'; ?></td>
                <td><a href="memberinbox.php?msgid=<?php echo $sentmsg['idMsg'];  ?>">View Message</a></td>
            </tr>  
            
            <?php endforeach;  ?>
        </tbody>
    </table> 
 <?php  }else{
       echo '<strong>No Message(s) Sent</strong>';
   }
   ?>
    
</div>
<?php
$body = ob_get_clean();
$objPage->displayPage($body);
?>   