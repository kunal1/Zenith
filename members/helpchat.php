<?php
// put your code here
session_start();
include_once './memberMasterPage.php';
require_once '../userInfoDB.php';
require_once '../Database.php';
require_once './Chatrequest.php';
require_once './Chatadmin.php';


//check login status
if (!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])) {
    header('Location: ../login.php');
}

$success = '';
$error = '';
$logged_uid = isset($_SESSION['loginUserId']) ? $_SESSION['loginUserId'] : 0;
$request = new Chatrequest();
$chat = new Chatadmin();

if (isset($_POST['stage'])) {
    switch ($_POST['stage']) {
        case 'request':
            $msg = $_POST['message'];
            if ($request->SendRequest($msg, $logged_uid)) {
                $success = "Your Chat Request Has Been Sent, Waiting For Admin Approval";
            } else {
                $error = "Unable to send request";
            }
            break;
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

if (isset($_GET['cl']) && $_GET['cl'] > 0) {
    if (isset($_GET['rid']) && $_GET['rid'] > 0) {
        if ($request->isExists($_GET['rid'])) {
            if ($request->update(array('status' => 2), array('sender' => $logged_uid))) {
                $success = "Request Closed Successfully";
            } else {
                $error = "Unable to close request";
            }
        } else {
            header('Location: helpchat.php');
        }
    } else {
        header('Location: helpchat.php');
    }
}

// ==================================== THIS CODE IS MUST  (START) ==============================================
$objPage = new memberMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
$objPage->setTitle('Zenith - User Help Chat');
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
    if (!$request->isAproved($logged_uid)) {


        if (!$request->isPending($logged_uid)) {
            ?>
            <form class="form-horizontal" action="helpchat.php" method="post" name="successform">
                <div class="form-group">
                    <label class="control-label" for="message" pull left>Enter Your Message: </label><br/>
                    <div class="col-md-12">
                        <textarea class="form-control" id="message" name="message" required></textarea>
                        <span class="help-block">Briefly explain your reason for chat</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-12"></label><br/>
                    <div class="col-md-4">
                        <input type="hidden" value="request" name="stage"/>
                        <input type="submit" value="Send Request" class="btn btn-success"/>
                    </div>
                </div>
            </form>
        <?php } else { ?>
            <h3>Pending Request</h3>
            <p>
                <?php
                $data = $request->getPending($logged_uid);
                echo $data['msg'];
                ?>
            </p>
            <p>
                <a href="helpchat.php?cl=1&&rid=<?php echo $data['id']; ?>" class="btn btn-success">Close this Request</a>
            </p>
            <?php
        }
    } else {
        ?>
        <form class="form-horizontal" action="helpchat.php" method="post" name="successform">
            <div class="form-group">
                <label class="control-label" for="message" pull left>Enter Your Message: </label><br/>
                <div class="col-md-12">
                    <textarea class="form-control" id="message" name="message" required></textarea>
                    <span class="help-block">Briefly explain your reason for chat</span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-12"></label><br/>
                <div class="col-md-4">
                    <input type="hidden" value="chat" name="stage"/>
                    <input type="submit" value="Send" class="btn btn-success"/>
                </div>
            </div>
        </form>
    <?php } ?>
</div>
<div style="clear: both; height: 20px;"></div>
<?php if ($request->isAproved($logged_uid)) { ?>
    <div>
        <h3>Coversation</h3>
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