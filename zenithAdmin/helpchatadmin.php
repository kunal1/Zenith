<?php
// put your code here
session_start();
include_once './adminMasterPage.php';
require_once '../userInfoDB.php';
require_once '../Database.php';
require_once '../members/Chatadmin.php';
require_once '../members/Chatrequest.php';


//check login status
if (!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])) {
    header('Location: ../login.php');
}

// check if the user have admin right
//if(notadmin){
//   header('Location: helpchat.php');
//}

$success = '';
$error = '';
$logged_uid = isset($_SESSION['loginUserId']) ? $_SESSION['loginUserId'] : 0;
$request = new Chatrequest();
$chat = new Chatadmin();

if (isset($_POST['stage'])) {
    switch ($_POST['stage']) {
        case 'chat':
            $msg = $_POST['message'];
            if (!empty($msg)) {
                if ($chat->SendMessage($msg, $logged_uid)) {
                    $success = "Message sent!";
                } else {
                    $error = "Unable to send message";
                }
            } else {
                $error = "You Can not send blank message";
            }
            break;
    }
}

// closing of a request chat
if (isset($_GET['cl']) && $_GET['cl'] > 0) {
    if (isset($_GET['rid']) && $_GET['rid'] > 0) {
        if ($request->isExists($_GET['rid'])) {
            if ($request->close($_GET['rid'])) {
               unset($_SESSION['rid']);
                //$chat->mailChat();// uncomment this to mail the chat to the user and delete all chat
                $success = "Request Closed Successfully";
            } else {
                $error = "Unable to close request";
            }
        } else {
            header('Location: helpchatadmin.php');
        }
    } else {
        header('Location: helpchatadmin.php');
    }
}

// deleting of a request chat
if (isset($_GET['dl']) && $_GET['dl'] > 0) {
    if (isset($_GET['rid']) && $_GET['rid'] > 0) {
        if ($request->isExists($_GET['rid'])) {
            if ($request->delete($_GET['rid'])) {
                $success = "Request Deleted Successfully";
            } else {
                $error = "Unable to Delete Request";
            }
        } else {
            header('Location: helpchatadmin.php');
        }
    } else {
        header('Location: helpchatadmin.php');
    }
}
// accepting a request chat

if (isset($_GET['ac']) && $_GET['ac'] > 0) {
     if (isset($_GET['rid']) && $_GET['rid'] > 0) {
        if ($request->isExists($_GET['rid'])) {
            if ($request->update(array('status' => 1), array('id' => $_GET['rid']))) {
                $_SESSION['rid'] = $_GET['rid'];
                $chat->SendMessage('Hello '.$request->getSenderID($_GET['rid']).' how may I help you', $request->getSenderID($_GET['rid']));
                $success = "Request Accepted Successfully";
            } else {
                $error = "Unable to Process Request";
            }
        } else {
            header('Location: helpchatadmin.php');
        }
    } else {
        header('Location: helpchatadmin.php');
    }
}

// ==================================== THIS CODE IS MUST  (START) ==============================================
$objPage = new adminMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
$objPage->setTitle('Zenith - Admin Chat Update');
$objPage->setMetaAuthor('Tunde Obatayo');
// ==================================== THIS CODE IS MUST  (END) ==============================================

ob_start();
if (!empty($success)) {
    ?>
    <p style="color: #F00;"><?php echo $success; ?></p>
    <?php
}

if (!empty($error)) {
    ?>
    <p style="color: #F00;"><?php echo $error; ?></p>
<?php } ?>
<div>
    <h2>Admin Help Chat</h2>
    <?php
    if (!$request->isAproved()) {

            ?>
            <h3>Pending Requests</h3>
         <hr/>
                <?php
                $allrequests = $request->getAll();
                if(empty($allrequests)){
                    echo '<p>No Request(s)</p>';
                }
                foreach ($allrequests as $req){
                ?>
            <p> 
                <small>By 
                  <?php echo $req['sender']; ?>  
                </small><br/>
                <?php echo $req['msg']; ?>
            </p>
            
            <p>
                <a href="helpchatadmin.php?dl=1&&rid=<?php echo $req['id']; ?>" class="btn btn-success">Delete this Request</a>
                <a href="helpchatadmin.php?ac=1&&rid=<?php echo $req['id']; ?>" class="btn btn-success">Accept this Request</a>
            </p>
        <hr/>
            <?php
                }
    } else {
        ?>
        <form class="form-horizontal" action="helpchatadmin.php" method="post" name="successform">
            <div class="form-group">
                <label class="control-label" for="message" pull left>Enter Your Message: </label><br/>
                <div class="col-md-12">
                    <textarea class="form-control" id="message" name="message" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-12"></label><br/>
                <div class="col-md-4">
                    <input type="hidden" value="chat" name="stage"/>
                    <input type="submit" value="Send" class="btn btn-success"/>
                    <a href="helpchatadmin.php?cl=1&&rid=<?php echo isset($_SESSION['rid']) ? $_SESSION['rid'] : 0; ?>" class="btn btn-success">Close Chat</a>
                </div>
            </div>
        </form>
    <?php } ?>
</div>
<div style="clear: both; height: 20px;"></div>
<?php if ($request->isAproved()) { ?>
    <div>
        <h3>Conversation</h3>
        <hr/>
        <div style="border: solid 1px #ccc; padding: 10px;">
            <?php $chats= $chat->getAll();
            if (!empty($chats)) {
                ?>
              
        <?php foreach ($chats as $chatmsg) { ?>
                     <p>
                         <strong><?php echo $chatmsg['sender'];//convert this to the username ?> <small>Says:</small> </strong><br/>
                    <?php echo $chatmsg['msg']; ?>
                </p>       

        <?php } } ?>
   
            </div>
        </div>
    <?php } ?>
    <?php
    $body = ob_get_clean();
    $objPage->displayPage($body);
    ?>     