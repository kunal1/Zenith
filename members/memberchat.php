<?php
    // put your code here
    session_start();   

    include_once './memberMasterPage.php';
    require_once '../userInfoDB.php';
    require_once '../core.inc.php';
    
    // note for me(jassi): make the following code querystring based
   // $_SESSION['loginUserId'] = 4;
    //$_SESSION['userFName'] = "Tunde";
    
    if(!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])){
            header( 'Location: ../index.php' ) ;
        }
 
        if(isset($_GET["searchUserId"])){
            $searchUserId = $_GET["searchUserId"]; // THIS WILL BE THE VALUE FROM QUERYSTRING
        }
        else {
            $searchUserId = $_SESSION['loginUserId'];
        }
 
        
        // ==================================== THIS CODE IS MUST  (START) ==============================================
        $objPage = new memberMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
        $objPage->setTitle('Zenith - Submit Sucess Story'); 
        $objPage->setMetaAuthor('this is meta author');
        // ==================================== THIS CODE IS MUST  (END) ==============================================
  
        $objUsers = new userInfoDB();
  
        $personalAcc = false;
        $act = '';
        if($searchUserId == $_SESSION['loginUserId']){
            $personalAcc = true;
            
            if(isset($_GET['actEdit'])){
                $act = $_GET['actEdit'];
            }
        }

        $newMsg = new chatApp();
        if(isset($_POST['sender'])) {
            if(sendMsg($_POST['sender'], $_POST['message'])){
            echo 'Message Sent.';
            }
            else{
            echo 'Message failed to send';
            }
        }

         
        
        //Text input
        
        $messages = getMsg();
        foreach($messages as $message){
        '<strong>'. $message['sender'].' Sent'.'</strong><br/>';
        $message['message']. '<br/><br/>';
        }
        $body .= '<div class="form-group">';
        $body = '<form class="form-horizontal" action="memberchat.php" method="post">';
        $body .= '<fieldset>';
        //Form Name -->
        $body .= '<legend>Chat Message</legend>'; 
    
       //Textarea 
        $body .= '<div class="form-group">';
        $body .= '<label class="control-label" for="message" pull left>Please tell us your story: </label><br/>';
        $body .= '<div class="col-md-12">';
        $body .= '<textarea class="form-control" id="message" name="message" required></textarea>';
        $body .= '<span class="help-block">Enter your story here(max 500 characters)</span>';
        $body .= '</div>';
        $body .= '</div>';
       
        //Submit Button 
        $sender = $_SESSION['loginUserId'];
        $body .= '<div class="form-group">';
        $body .= '<label class="col-md-8 control-label" for="getMsg"></label>';
        $body .= '<div class="col-md-4">';
        $body .= "<input type='hidden' name='sender' value='{$sender}'/>";                    
        $body .= '<button id="sendMsg" name="sendMsg" class="btn btn-success">Send</button>';
        $body .= '</div>';
        $body .= '</div>';
        $body .= '</fieldset>';
        $body .= '</form>';

        $objPage->displayPage($body);
        
?>        