<?php
       
    include_once 'adminMasterPage.php';
    include_once '../membershipPlansDB.php';
    
    
//    $_SESSION['loginUserId'] = 1;
//    $_SESSION['userFName'] = "Jagsir Singh";
    session_start();    
      
    
    if(!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])){
            header( 'Location: ../index.php' ) ;
        }
        
        
    // ==================================== THIS CODE IS MUST  (START) =============================================================
    $objPage = new adminMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
    $objPage->setTitle('Zenith - Membership Plans'); 
    $objPage->setMetaAuthor('this is meta author');
    // ==================================== THIS CODE IS MUST  (END) =================================================================
    
    $objMembership = new membershipPlansDB();
    
    $memberships = $objMembership->getMembershipPlans();
    
    $body = "<form class='form-horizontal' id='form1' method='post'>";
    $body .= "<br/>";
    $body .= "<label style='color:Red;' name='lblMsg' id='lblMsg'></label><br/>";
    $body .= "<div id='divForm'>";        
        $body .= "<div class='form-group'>";
            $body .= "<label class='col-md-4 control-label'>Title:</label>";
            $body .= "<div class='col-md-4'>";
            $body .= "<input type='text' id='txtTitle' class='form-control input-md input-lg' required='required' />";
                $body .= "<div id='errTitle' style='color:red'></div>";
            $body .= "</div>";
            $body .= "<div class='col-md-4'>";
            $body .= "</div>";
        $body .= "</div>";      
        $body .= "<div class='form-group'>";
            $body .= "<label class='col-md-4 control-label'>Days Allowed:</label>";
            $body .= "<div class='col-md-4'>";
            $body .= "<input type='text' id='txtDays' class='form-control input-md input-lg' required='required' />";
            $body .= "<div id='errDays' style='color:red'></div>";
            $body .= "</div>";
            $body .= "<div class='col-md-4'>";
            $body .= "</div>";
        $body .= "</div>";      
        $body .= "<div class='form-group'>";
            $body .= "<label class='col-md-4 control-label'>Contacts Allowed:</label>";
            $body .= "<div class='col-md-4'>";
            $body .= "<input type='text' id='txtContact' class='form-control input-md input-lg' required='required' />";
            $body .= "<div id='errContact' style='color:red'></div>";
            $body .= "</div>";
            $body .= "<div class='col-md-4'>";
            $body .= "</div>";
        $body .= "</div>";      
        $body .= "<div class='form-group'>";
            $body .= "<label class='col-md-4 control-label'>Price:</label>";
            $body .= "<div class='col-md-4'>";
            $body .= "<input type='text' id='txtPrice' class='form-control input-md input-lg' required='required' />";
            $body .= "<div id='errPrice' style='color:red'></div>";
            $body .= "</div>";
            $body .= "<div class='col-md-4'>";
            $body .= "</div>";
        $body .= "</div>";     
        $body .= "<div class='form-group'>";
            $body .= "<label class='col-md-4 control-label'>Comments:</label>";
            $body .= "<div class='col-md-4'>";
            $body .= "<input type='text' id='txtComments' class='form-control input-md input-lg' required='required' />";
            $body .= "<div id='errComments' style='color:red'></div>";
            $body .= "</div>";
            $body .= "<div class='col-md-4'>";
            $body .= "</div>";
        $body .= "</div>";

        $body .= "<div  class='form-group'>";
            $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
            $body .= "<div class='col-md-4'>";
            $body .= "<input type='hidden' id='hdnMemId'/>";
            $body .= "<input type='submit' name='btnSU' id='btnSU' value='Save' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
            $body .= "<a href='#' id='cancPlan' class='btn btn-success'>Cancel</a>";
            $body .= "</div>"; 
            $body .= "<div class='col-md-4'>";
            $body .= "</div>";           
        $body .= "</div>";
        
    $body .= "</div>";
    
    $body .= "<div id='divRecords'>";    
        $body .= "<div class='form-group'>";
            $body .= "<div class='col-md-12'>";
                $body .= "<a href='#' id='addNew' class='btn btn-success'>Add New Membership Plan</a>";
            $body .= "</div>";
        $body .= "</div>";
    if(count($memberships)>0)
    {
        for($ind = 0; $ind < count($memberships); $ind++):
            
            $body .= "<div class='form-group col-md-6' id='divRec_{$memberships[$ind]['membershipId']}'>";
        
                $body .= "<div class='form-group col-md-12'>";
                    $body .= "<label class='col-md-6 control-label'>Title:</label>";
                    $body .= "<div class='col-md-6'>";
                    $body .= "<label id='lblTitle_{$memberships[$ind]['membershipId']}' class='control-label' style='font-weight:normal;'>{$memberships[$ind]['membership']}</label>";
                    $body .= "</div>";
                $body .= "</div>";

                $body .= "<div class='form-group col-md-12'>";
                    $body .= "<label class='col-md-6 control-label'>Days Allowed:</label>";
                    $body .= "<div class='col-md-6'>";
                    $body .= "<label id='lblDays_{$memberships[$ind]['membershipId']}' class='control-label' style='font-weight:normal;'>{$memberships[$ind]['daysAllowed']}</label>";
                    $body .= "</div>";
                $body .= "</div>";

                $body .= "<div class='form-group col-md-12'>";
                    $body .= "<label class='col-md-6 control-label'>Contacts:</label>";
                    $body .= "<div class='col-md-6'>";
                    $body .= "<label id='lblContacts_{$memberships[$ind]['membershipId']}' class='control-label' style='font-weight:normal;'>{$memberships[$ind]['contactsAllowed']}</label>";
                    $body .= "</div>";
                $body .= "</div>";

                $body .= "<div class='form-group col-md-12'>";
                    $body .= "<label class='col-md-6 control-label'>Price:</label>";
                    $body .= "<div class='col-md-6'>";
                    $body .= "$ ";
                    $body .= "<label id='lblPrice_{$memberships[$ind]['membershipId']}' class='control-label' style='font-weight:normal;'>{$memberships[$ind]['price']}</label>";
                    $body .= " CA";
                    $body .= "</div>";
                $body .= "</div>";

                $body .= "<div class='form-group col-md-12'>";
                    $body .= "<label id='lblComments_{$memberships[$ind]['membershipId']}' class='control-label' style='font-weight:normal;'>{$memberships[$ind]['comments']}</label>";
                $body .= "</div>";

                $body .= "<div  class='form-group col-md-12'>";
                $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
                $body .= "<div class='col-md-8'>";
                $body .= "<input type='submit' id='updMembership_{$memberships[$ind]['membershipId']}' "
                . "onclick='showUpdate(" . $memberships[$ind]['membershipId'] . ",";
                $body .=  '"'. $memberships[$ind]['membership'] . '"';
                $body .= "," . '"' . $memberships[$ind]['daysAllowed'] . '"';
                $body .= "," . '"' . $memberships[$ind]['contactsAllowed'] . '"';
                $body .= "," . '"' . $memberships[$ind]['price'] . '"';
                $body .= "," . '"' . $memberships[$ind]['comments'] . '"';
                $body .= "); return false;' value='Edit' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
                $body .= "<input type='submit' id='delMembership_{$memberships[$ind]['membershipId']}' onclick='deleteMembership(" . $memberships[$ind]['membershipId'] . "); return false;' value='Delete' class='btn btn-success' />";
                $body .= "</div>";            
                $body .= "</div>";

                $body .= "<div  class='form-group col-md-12'>";
                    $body .= "<hr/>";
                $body .= "</div>";    
            
            $body .= "</div>";    
            
//            $body .= "<div class='form-group col-md-1' >";
//            $body .= "</div>";   
        endfor;
    }
    
    $body .= "</div>";
    
    $body .= "</form>";  
       
 $objPage->displayPage($body);
    
?>