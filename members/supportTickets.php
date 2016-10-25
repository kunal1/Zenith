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
         
        // ==================================== THIS CODE IS MUST  (START) ==============================================
        $objPage = new memberMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
        $objPage->setTitle('Zenith - Profile'); 
        $objPage->setMetaAuthor('this is meta author');
        // ==================================== THIS CODE IS MUST  (END) ==============================================
        
        $objTickets = new supportTicketsDB();
        $allTickets =$objTickets->getSUserTickets($_SESSION['loginUserId']);
        
       // $r = supportTicketsDB::saveTicketReply(7, 4,'2014-05-04 10:24:25', 'direct value from form', 'False');
        //echo $r;
   
        $body = "<form class='form-horizontal' method='post'>";
        $body .= "<input type='hidden' id='hdUId' name='hdUId' value='{$_SESSION['loginUserId']}'>";
        $body .= "<script type='text/javascript' src='../js/supportTickets.js'></script>";
        $body .= "<br/>";
        $body .= "<label style='color:Red;' name='lblMsg' id='lblMsg'></label><br/>";  
        
        $body .= "<div id='divForm'>";        
             $body .= "<div class='form-group'>";
                 $body .= "<label class='col-md-4 control-label'>Department:</label>";
                 $body .= "<div class='col-md-8'>";
                 $body .= "<select name='ddlDepartments' id='ddlDepartments' class='form-control input-lg'>";
                 $body .= "</select>";
                 $body .= "</div>";
             $body .= "</div>";       
                   
             $body .= "<div class='form-group'>";
                 $body .= "<label class='col-md-4 control-label'>Subject:</label>";
                 $body .= "<div class='col-md-8'>";
                    $body .= "<input type='text' name='txtSubject' id='txtSubject' class='form-control input-md input-lg' required='required'/>";
                    $body .= "<div id='errSubject' style='color:red'></div>";
                $body .= "</div>";
             $body .= "</div>";       
                   
             $body .= "<div class='form-group'>";
                 $body .= "<label class='col-md-4 control-label'>Message:</label>";
                 $body .= "<div class='col-md-8'>";
                    $body .= "<textarea rows='5' cols='50' name='txtMessage' id='txtMessage' class='form-control input-md input-lg' required='required'>";
                    $body .= "</textarea>";
                    $body .= "<div id='errMessage' style='color:red'></div>";
                $body .= "</div>";
             $body .= "</div>";         

            $body .= "<div  class='form-group col-md-12'>";
                $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
                $body .= "<div class='col-md-8'>";
                    $body .= "<input type='submit' id='btnSave' value='Save' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
                    $body .= "<input type='submit' id='btnCancel' value='Cancel' class='btn btn-success' />";
                $body .= "</div>";            
            $body .= "</div>";
        $body .= "</div>";
        
        $body .= "<div id='divRecords'>";        
            $body .= "<div class='form-group'>";
                $body .= "<div class='col-md-12'>";
                    $body .= "<a href='#' id='addNew' class='btn btn-success'>New Ticket</a>";
                $body .= "</div>";
            $body .= "</div>";
            if(count($allTickets) > 0){
                foreach($allTickets as $ticket):
                    $body .= "<div id='divRec_{$ticket['supportTicketId']}'>";
                        $body .= "<div class='form-group'>";
                            $body .= "<label class='col-md-4 control-label'>Ticket Id:</label>";
                            $body .= "<div class='col-md-8'>";
                                $body .= "<label id='lblTId_{$ticket['supportTicketId']}' class='control-label' style='font-weight:normal;'>{$ticket['supportTicketId']}</label>";
                            $body .= "</div>";        
                        $body .= "</div>";     

                        $body .= "<div class='form-group'>";
                            $body .= "<label class='col-md-4 control-label'>Subject:</label>";
                            $body .= "<div class='col-md-8'>";
                                $body .= "<a href='ticketReply.php?ticketId={$ticket['supportTicketId']}'>{$ticket['Subject']}</a>";
                            $body .= "</div>";        
                        $body .= "</div>";  

                        $body .= "<div class='form-group'>";
                            $body .= "<label class='col-md-4 control-label'>Department:</label>";
                            $body .= "<div class='col-md-8'>";
                                $body .= "<label id='lblDep_{$ticket['supportTicketId']}' class='control-label' style='font-weight:normal;'>{$ticket['department']}</label>";
                            $body .= "</div>";        
                        $body .= "</div>"; 

                        $body .= "<div class='form-group'>";
                            $body .= "<label class='col-md-4 control-label'>Submit Date:</label>";
                            $body .= "<div class='col-md-8'>";
                                $body .= "<label id='lblDate_{$ticket['supportTicketId']}' class='control-label' style='font-weight:normal;'>{$ticket['submitDate']}</label>";
                            $body .= "</div>";        
                        $body .= "</div>";    

                        $body .= "<div  class='form-group'>";
                            $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
                            $body .= "<div class='col-md-8'>";
                                $body .= " <a href='#' id='btnClose' onclick='closeTicket({$ticket['supportTicketId']});return false;' class='btn btn-success'>Close</a>&nbsp;&nbsp;&nbsp;";
                                $body .= "<a href='ticketReply.php?ticketId={$ticket['supportTicketId']}' id='btnReply' class='btn btn-success'>Reply</a>";
                            $body .= "</div>";            
                        $body .= "</div>";

                        $body .= "<div class='form-group'>";
                        $body .= "<hr />";
                        $body .= "</div>";  
                    $body .= "</div>";                  
                endforeach;   
            }
        $body .= "</div>";
        
        $body .= "</form>";        
        
 $objPage->displayPage($body);
?>
