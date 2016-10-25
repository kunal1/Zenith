
<?php 
    session_start();    
    require_once 'publicMasterPage.php';
    require_once 'membershipPlansDB.php';
        
    // ==================================== THIS CODE IS MUST  (START) ==============================================
    $objPage = new publicMasterPage();       
    $objPage->setTitle('Zenith - Membership Plans'); 
    $objPage->setMetaAuthor('this is meta author');
    // ==================================== THIS CODE IS MUST  (END) ==============================================
    $objMem = new membershipPlansDB();
    $allPlans = $objMem->getMembershipPlans();
    
    $body = "<form class='form-horizontal' method='post'>";
    $body .= "<br/>";
    $body .= "<h3><strong>Membership Plans</strong></h4><br/>";
    foreach($allPlans as $plan):
        $membId = $plan['membershipId'];
        $title = $plan['membership'];
        $days = $plan['daysAllowed'];
        $price = "$" . $plan['price'] . " CA";
        $contactsAllowed = $plan['contactsAllowed'];
        $comments = $plan['comments'];
            $body .= "<div  class='form-group'>";
                $body .= "<div class='col-md-12'><h4><strong>{$title}</strong></h4></div>";
                $body .= "<div class='col-md-1'><strong>Days:</strong></div>";
                $body .= "<div class='col-md-2'>";
                    $body .= "{$days}";
                $body .= "</div>";
                $body .= "<div class='col-md-2'><strong>Contacts:</strong></div>";
                $body .= "<div class='col-md-3'>";
                    $body .= "{$contactsAllowed}";
                $body .= "</div>";
                $body .= "<div class='col-md-1'><strong>Price:</strong></div>";
                $body .= "<div class='col-md-3'>";
                    $body .= "{$price}";
                $body .= "</div>";
            $body .= "</div>";
            $body .= "<div  class='form-group'>";
                $body .= "<div class='col-md-12'><strong>Comments:</strong> {$comments}</div>";
            $body .= "</div>";
            $body .= "<div  class='form-group'>";
                $body .= "<div class='col-md-12'><hr /></div>";  
            $body .= "</div>";
    endforeach;
    $body .= "</form>";  
        
    $objPage->displayPage($body);
?>