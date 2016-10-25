<?php
    // put your code here
    session_start();    
    include_once 'adminMasterPage.php';
    require_once '../supportTicketsDB.php';
 
    // note for me(jassi): make the following code querystring based
    //$_SESSION['loginUserId'] = 4;
    //$_SESSION['userFName'] = "Tunde";
    
    if(!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])){
            header( 'Location: ../index.php' ) ;
        }
         
        // ==================================== THIS CODE IS MUST  (START) ==============================================
        $objPage = new adminMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
        $objPage->setTitle('Zenith - Profile'); 
        $objPage->setMetaAuthor('this is meta author');
        // ==================================== THIS CODE IS MUST  (END) ==============================================
        
        $objTickets = new supportTicketsDB();
        $allTickets =$objTickets->getSUserTickets(0);
        
  $body = "<form class='form-horizontal' method='post'>";
        $body .= "<input type='hidden' id='hdUId' name='hdUId' value='{$_SESSION['loginUserId']}'>";
        $body .= "<script type='text/javascript' src='../js/supportTicketAdmin.js'></script>";
        $body .= "<br/>";
        $body .= "<label style='color:Red;' name='lblMsg' id='lblMsg'></label><br/>";  
        
        $body .= "<div class='form-group'>";
            $body .= "<div class='col-md-12'>";
                $body .= "<select name='ddlDepartments' id='ddlDepartments' onchange='loadTickets();' class='form-control input-lg'>";
                $body .= "</select>";
            $body .= "</div>";
        $body .= "</div>";
    
        $body .= "<div id='divRecords'>";  
        $body .= "</div>";
        
        $body .= "</form>";        
        
 $objPage->displayPage($body);
?>
