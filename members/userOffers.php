<?php
    // put your code here
    session_start();    
    include_once 'memberMasterPage.php';
    include_once '../specialOffersDB.php';
//    require_once '../userInfoDB.php';
//    require_once '../commonDB.php';
    
    
    
    if(!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])){
            header( 'Location: ../index.php' ) ;
        }
    $userId = $_SESSION['loginUserId'];
        
       
        $obj = new memberMasterPage($userId);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
        $obj->setTitle('Zenith - Special Offers'); 
        $obj->setMetaAuthor('this is meta author');
       
        $objOffer = new specialOffersDB();
        $allOffers = $objOffer->getSpecialOffers();
        //$myPlan = $objMem->getUserMembershipDetails($userId);
        
        $body = "<form class='form-horizontal' method='post'>";
        $body .= "<br/>";
        
//        if(count($myPlan)>0):
//            $plan = $myPlan[0]['membership'];
//            $membershipId = $myPlan[0]['membershipId'];
//            $startDate = $myPlan[0]['startDate'];
//            $endDate = $myPlan[0]['endDate'];
//            $alConts = $myPlan[0]['allowedContacts'];
//            $remContacts = $myPlan[0]['remainingContacts'];
//            
//            $body .= "<br/>";
//            $body .= "<div  class='form-group'>";
//                $body .= "<div class='col-md-12'><h4>You already are have <strong>{$plan}</strong> Plan</h4></div>";
//                $body .= "<div class='col-md-3'><strong>Start Date:</strong></div>";
//                $body .= "<div class='col-md-3'>{$startDate}</div>";
//                $body .= "<div class='col-md-3'><strong>End Date:</strong></div>";
//                $body .= "<div class='col-md-3'>{$endDate}</div>";
//            $body .= "</div>";
//            $body .= "<div  class='form-group'>";
//                $body .= "<div class='col-md-3'><strong>Allowed Contacts:</strong></div>";
//                $body .= "<div class='col-md-3'>{$alConts}</div>";
//                $body .= "<div class='col-md-3'><strong>Remaining Contacts:</strong></div>";
//                $body .= "<div class='col-md-3'>{$remContacts}</div>";
//            $body .= "</div>";
//            $body .= "<div  class='form-group'>";
//                $body .= "<div class='col-md-8'></div>";
//                $body .= "<div class='col-md-4'>";
//                    $body .= "<a href='subscribe.php?memId={$membershipId}' class='btn btn-success'>Renew</a>";                      
//                $body .= "</div>"; 
//            $body .= "</div>";
//            $body .= "<div  class='form-group'>";
//            $body .= "<hr />";
//            $body .= "</div>";
//        endif;
        
        $body .= "<h3>Offers</h3><br/>";
        
      
        foreach($allOffers as $offer):
            $speId = $offer['specialId'];
            $title = $offer['special'];
            $days = $offer['daysAllowed'];
            $price = "$" . $offer['price'] . " CA";
         
                $body .= "<div  class='form-group'>";
                    $body .= "<div class='col-md-12'><h4><strong>{$title}</strong></h4></div>";
                    $body .= "<div class='col-md-2'><strong>Days:</strong></div>";
                    $body .= "<div class='col-md-1'>";
                        $body .= "{$days}";
                    $body .= "</div>";
                   
                    $body .= "<div class='col-md-2'><strong>Price:</strong></div>";
                    $body .= "<div class='col-md-3'>";
                        $body .= "{$price}";
                    $body .= "</div>";
                $body .= "</div>";
               
                $body .= "<div  class='form-group'>";
                    $body .= "<div class='col-md-8'></div>";
                    $body .= "<div class='col-md-4'>";
//                        if(count($myPlan)>0):
//                            $body .= "<a href='subscribe.php?memId={$membId}' class='btn btn-success'>Upgrade</a>";   
//                        else:                            
//                            $body .= "<a href='subscribe.php?memId={$membId}' class='btn btn-success'>Subscribe</a>"; 
//                        endif;                  
                        $body .= "<a href='cart.php?speId={$speId}' class='btn btn-success'>Subscribe</a>";                      
                    $body .= "</div>"; 
                $body .= "</div>";
                $body .= "<div  class='form-group'>";
                    $body .= "<div class='col-md-12'><hr /></div>";  
                $body .= "</div>";
        endforeach;
        $body .= "</form>";  
        
 $obj->displayPage($body);
?>