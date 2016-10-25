<?php
    // put your code here
    session_start();    
    include_once 'memberMasterPage.php';
    require_once '../supportTicketsDB.php';
 
    // note for me(jassi): make the following code querystring based
    //$_SESSION['loginUserId'] = 4;
    //$_SESSION['userFName'] = "Tunde";
    
    if(!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])){
            header( 'Location: ../Login.aspx' ) ;
        }
        $userId = $_SESSION['loginUserId'];
        if(isset($_GET["ticketId"])){
            $ticketId = $_GET["ticketId"]; // THIS WILL BE THE VALUE FROM QUERYSTRING
        }
        else {
            header( 'Location: ../Login.aspx' ) ;
        }
         
        // ==================================== THIS CODE IS MUST  (START) ==============================================
        $objPage = new memberMasterPage($userId);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
        $objPage->setTitle('Zenith - Profile'); 
        $objPage->setMetaAuthor('this is meta author');
        // ==================================== THIS CODE IS MUST  (END) ==============================================
        
        $objTickets = new supportTicketsDB();
        $ticketHistory = $objTickets->getTicketDetails($ticketId);   
        
        $body = "<form class='form-horizontal' method='post'>";
        $body .= "<input type='hidden' id='hdUId' name='hdUId' value='{$userId}'>"; 
        $body .= "<input type='hidden' id='hdTRep' name='hdTRep' value='No'>"; 
        $body .= "<script type='text/javascript' src='../js/ticketReply.js'></script>";    
        $body .= "<label style='color:Red;' name='lblMsg' id='lblMsg'></label><br/>";       
        if(count($ticketHistory)>0)
        {     
            $body .= "<div id='divForm'>";                      
                $body .= "<div class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Ticket Id:</label>";
                    $body .= "<div class='col-md-8'>";
                       $body .= "<input type='text' name='txtId' id='txtId' class='form-control input-md input-lg' value='{$ticketId}' readonly='readonly'/>";
                    $body .= "</div>";
                $body .= "</div>";   

                $body .= "<div class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Subject:</label>";
                    $body .= "<div class='col-md-8'>";
                       $body .= "<input type='text' name='txtSubject' id='txtSubject' class='form-control input-md input-lg' value='{$ticketHistory[0]['subject']}' readonly='readonly'/>";
                    $body .= "</div>";
                $body .= "</div>";           

                $body .= "<div class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Message:</label>";
                    $body .= "<div class='col-md-8'>";
                       $body .= "<textarea rows='5' cols='50' name='txtMessage' id='txtMessage' class='form-control input-md input-lg' required='required'>";
                       $body .= "</textarea>";
                    $body .= "</div>";
                $body .= "</div>";             

               $body .= "<div  class='form-group col-md-12'>";
                   $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
                   $body .= "<div class='col-md-8'>";
                       $body .= "<input type='submit' id='btnSave' value='Save' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
                       $body .= "<input type='submit' id='btnCancel' value='Cancel' formnovalidate='false' class='btn btn-success' />";
                   $body .= "</div>";            
               $body .= "</div>";                                                                
            $body .= "</div>";    
        
            $body .= "<div id='divRecords'>";   
                $body .= "<div  class='form-group col-md-12'>";  
                $body .= "<h3>Ticket {$ticketId} History</h3>";
                $body .= "</div>";          
                
                $body .= "<div  class='form-group col-md-12' style='padding-bottom: 10px;'>";
                    $body .= "<table class='ticketHis' id='ticketHis'>";
                    foreach($ticketHistory as $msg):
                        if($msg['userId'] == $userId){
                            $body .= "<tr>";
                                $body .= "<td><div class='meCol'>Me:  </div></td><td><div class='divMe'>{$msg['message']}</td></div>";
                            $body .= "</tr>";
                        }
                        else{
                            $body .= "<tr>";
                                $body .= "<td><div class='otherCol'>Zenith Team:  </div></td><td><div class='divOther'>{$msg['message']}</div>";
                            $body .= "</tr>";
                        }
                    endforeach;
                    $body .= "</table>";
                $body .= "</div>"; 
                
                $body .= "<div  class='form-group col-md-12'>"; 
                   $body .= "<label class='col-md-7 control-label'>&nbsp;</label>";
                   $body .= "<div class='col-md-5'>";
                       $body .= "<input type='submit' id='btnReply' value='Reply' class='btn btn-success' />&nbsp;";
                       $body .= "<a href='supportTickets.php' id='btnGo' class='btn btn-success'>Go Back</a>";
                   $body .= "</div>"; 
                $body .= "</div>"; 
            $body .= "</div>";          
        }
        $body .= "</form>";        
        
 $objPage->displayPage($body);
?>