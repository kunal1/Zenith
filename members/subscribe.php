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

    // ==================================== THIS CODE IS MUST  (START) ========================================================
    $objPage = new memberMasterPage($userId);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
    $objPage->setTitle('Zenith - Profile'); 
    $objPage->setMetaAuthor('this is meta author');
    // ==================================== THIS CODE IS MUST  (END) ==========================================================

    $body = "<form class='form-horizontal' method='post'>";
    $body .= "<br/>";        
    if(!isset($_GET["memId"])){
    }
    else { 
        $memId = $_GET["memId"]; // THIS WILL BE THE VALUE FROM QUERYSTRING         

        $objMem = new membershipPlansDB();
        $planDet = $objMem->getMembershipPlanDetails($memId);

        if(count($planDet)>0):
            $plan = $planDet[0]['membership'];
            $dayAll = $planDet[0]['daysAllowed'];
            $alConts = $planDet[0]['contactsAllowed'];
            $price = $planDet[0]['price'];

//            $body .= "<div  class='form-group'>";
//                $body .= "<label class='col-md-2 control-label'>Note:</label>";
//                $body .= "<div class='col-md-10'>"; 
//                    $body .= "<label id='lblPlan' name='lblPlan' style='font-weight: normal;'>Changing or renewing a plan before expiry date "
//                        . "will add your remaining days and contacts to new plan.</label>";   
//                $body .= "</div>"; 
//            $body .= "</div>";
            $body .= "<br/>";
            $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-6 control-label'>Membership Plan:</label>";
                $body .= "<div class='col-md-6'>"; 
                    $body .= "<label id='lblPlan' name='lblPlan' style='font-weight: normal;'>{$plan}</label>";   
                $body .= "</div>"; 
            $body .= "</div>";
            $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-6 control-label'>Days Allowed:</label>";
                $body .= "<div class='col-md-6'>"; 
                    $body .= "<label id='lblDays' name='lblDays' style='font-weight: normal;'>{$dayAll}</label>";   
                $body .= "</div>"; 
            $body .= "</div>";
            $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-6 control-label'>Contacts Allowed:</label>";
                $body .= "<div class='col-md-6'>"; 
                    $body .= "<label id='lblContacts' name='lblContacts' style='font-weight: normal;'>{$alConts}</label>";   
                $body .= "</div>"; 
            $body .= "</div>";
            $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-6 control-label'>Price:</label>";
                $body .= "<div class='col-md-6'>"; 
                    $body .= "<label id='lblPrice' name='lblPrice' style='font-weight: normal;'>{$price}</label>";   
                $body .= "</div>"; 
            $body .= "</div>";
            $body .= "<div  class='form-group'>";
                $body .= "<div class='col-md-6'></div>";
                $body .= "<div class='col-md-6'>";
//                    $body .="<a href='success.php?ptrb={$userId}&item_number={$memId}&tx=2'>Test</a><br/>";
                    $body .= "<a href='https://sandbox.paypal.com/cgi-bin/webscr"
                            . "?cmd=_xclick"
                            . "&business=kaur.dalbir@ymail.com"
                            . "&item_name={$plan}"
                            . "&amount={$price}"
                            . "&item_number={$memId}"
                            . "&return=http://www.jagsirsingh.com/zenith/members/success.php?ptrb={$userId}"
                            . "&cancel_return=http://www.jagsirsingh.com/zenith/members/subscribe.php?memId={$memId}"
                            . "&currency=CAD' class='btn btn-success' >Proceed to checkout</a>";
                $body .= "</div>";
            $body .= "</div>";     
          
        endif;
        
    }
    $body .= "</form>";  
    $objPage->displayPage($body);
?>