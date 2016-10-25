<?php
    // put your code here
    session_start();    
    include_once 'memberMasterPage.php';
    include_once '../membershipPlansDB.php';
//    require_once '../userInfoDB.php';
//    require_once '../commonDB.php';
    
    
    
    if(!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])):
        header( 'Location: ../index.php' ) ;
    endif;
    $userId = $_SESSION['loginUserId'];      
    $objMem = new membershipPlansDB();

        if(isset($_GET["ptrb"])){
            $usId = $_GET["ptrb"]; // THIS WILL BE THE VALUE FROM QUERYSTRING
            $memId=$_GET['item_number'];
            $transId=$_GET['tx'];
            $objMem->addUserToMembership($userId, $memId);
        }
        
    // ==================================== THIS CODE IS MUST  (START) ========================================================
    $objPage = new memberMasterPage($userId);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
    $objPage->setTitle('Zenith - Profile'); 
    $objPage->setMetaAuthor('this is meta author');
    // ==================================== THIS CODE IS MUST  (END) ==========================================================
    
    

    $body = "<form class='form-horizontal' action='https://sandbox.paypal.com/cgi-bin/webscr' method='post'>";
    $body .= "<br/>";        
     $body .= "<div  class='form-group'>";
        $body .= "<label class='col-md-2 control-label'>Note:</label>";
        $body .= "<div class='col-md-10'>"; 
            $body .= "<label id='lblPlan' name='lblPlan' style='font-weight: normal;'>You are now premium member of the website.</label>";   
        $body .= "</div>"; 
    $body .= "</div>";
    
    $body .= "</form>";  
    $objPage->displayPage($body);
?>