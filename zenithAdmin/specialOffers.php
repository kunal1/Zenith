<?php
 include_once 'adminMasterPage.php';
 include_once '../specialOffersDB.php';
 
  session_start(); 
  
  if(!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId']))
      {
            header( 'Location: ../index.php' ) ;
      }
      
       $obj = new adminMasterPage($_SESSION['loginUserId']);
       
    $objOffers = new specialOffersDB();
    $offers = $objOffers->getSpecialOffers();
    
    
    
     $body = "<form class='form-horizontal' method='post'>";
    $body .= "<br/>";
    $body .= "<label style='color:Red;' name='lblMsg' id='lblMsg'></label><br/>";
    $body .= "<div id='divForms'>";        
        $body .= "<div class='form-group'>";
            $body .= "<label class='col-md-4 control-label'>Title:</label>";
            $body .= "<div class='col-md-4'>";
            $body .= "<input type='text' id='txtTitle' class='form-control input-md input-lg' required='required' />";
            $body .= "</div>";
            $body .= "<div class='col-md-4'>";
            $body .= "</div>";
        $body .= "</div>";      
        $body .= "<div class='form-group'>";
            $body .= "<label class='col-md-4 control-label'>Days Allowed:</label>";
            $body .= "<div class='col-md-4'>";
            $body .= "<input type='text' id='txtDays' class='form-control input-md input-lg' required='required' />";
            $body .= "</div>";
            $body .= "<div class='col-md-4'>";
            $body .= "</div>";
        $body .= "</div>";           
        $body .= "<div class='form-group'>";
            $body .= "<label class='col-md-4 control-label'>Price:</label>";
            $body .= "<div class='col-md-4'>";
            $body .= "<input type='text' id='txtPrice' class='form-control input-md input-lg' required='required' />";
            $body .= "</div>";
            $body .= "<div class='col-md-4'>";
            $body .= "</div>";
        $body .= "</div>";     

        $body .= "<div  class='form-group'>";
            $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
            $body .= "<div class='col-md-4'>";
            $body .= "<input type='hidden' id='hdnSpeId'/>";
            $body .= "<input type='submit' name='btnOffer' id='btnOffer' value='Save' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
            $body .= "<a href='#' id='cancOffer' class='btn btn-success'>Cancel</a>";
            $body .= "</div>"; 
            $body .= "<div class='col-md-4'>";
            $body .= "</div>";           
        $body .= "</div>";
        
          $body .= "</div>";
          
          
          
           $body .= "<div id='divRecord'>";
    
    $body .= "<div class='form-group'>";
    $body .= "<div class='col-md-12'>";
    $body .= "<a href='#' id='addNewOffer' class='btn btn-success'>Add New Special Offer</a>";
    $body .= "</div>";
    $body .= "</div>";
    if(count($offers)>0)
    {
        for($i = 0; $i < count($offers); $i++):
    
              $body .= "<div class='form-group col-md-5' id='divReco_{$offers[$i]['specialId']}'>";
          
        
                $body .= "<div class='form-group col-md-12'>";
                    $body .= "<label class='col-md-6 control-label'>Title:</label>";
                    $body .= "<div class='col-md-6'>";
                    $body .= "<label id='lblTitle_{$offers[$i]['specialId']}' class='control-label' style='font-weight:normal;'>{$offers[$i]['special']}</label>";
                    $body .= "</div>";
                $body .= "</div>";

                $body .= "<div class='form-group col-md-12'>";
                    $body .= "<label class='col-md-6 control-label'>Days Allowed:</label>";
                    $body .= "<div class='col-md-6'>";
                    $body .= "<label id='lblDays_{$offers[$i]['specialId']}' class='control-label' style='font-weight:normal;'>{$offers[$i]['daysAllowed']}</label>";
                    $body .= "</div>";
                $body .= "</div>";


                $body .= "<div class='form-group col-md-12'>";
                    $body .= "<label class='col-md-6 control-label'>Price:</label>";
                    $body .= "<div class='col-md-6'>";
                    $body .= "$ ";
                    $body .= "<label id='lblPrice_{$offers[$i]['specialId']}' class='control-label' style='font-weight:normal;'>{$offers[$i]['price']}</label>";
                    $body .= " CA";
                    $body .= "</div>";
                $body .= "</div>";


                $body .= "<div  class='form-group col-md-12'>";
                $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
                $body .= "<div class='col-md-8'>";
                $body .= "<input type='submit' id='updOffer_{$offers[$i]['specialId']}' onclick='showOfferUpdate(" . $offers[$i]['specialId'] . "); return false;' value='Edit' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
                $body .= "<input type='submit' id='delOffer_{$offers[$i]['specialId']}' onclick='deleteTheOffer(" . $offers[$i]['specialId'] . "); return false;' value='Delete' class='btn btn-success' />";
                $body .= "</div>";            
                $body .= "</div>";

                $body .= "<div  class='form-group col-md-12'>";
                    $body .= "<hr/>";
                $body .= "</div>";    
            
            $body .= "</div>";    
            
            $body .= "<div class='form-group col-md-1' >";
            $body .= "</div>";   
        endfor;
    }
    
    $body .= "</div>";
    
    $body .= "</form>";  
       
 $obj->displayPage($body);
?>

