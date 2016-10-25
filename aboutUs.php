<?php 
    session_start();  
    require_once 'publicMasterPage.php';
        
    // ==================================== THIS CODE IS MUST  (START) ==============================================
    $objPage = new publicMasterPage();       
    $objPage->setTitle('Zenith - About Us'); 
    $objPage->setMetaAuthor('this is meta author');
    // ==================================== THIS CODE IS MUST  (END) ==============================================
    
    $body = "<form class='form-horizontal' method='post'>";
    $body .= "<br/>";
    $body .= "<h3><strong>About Us</strong></h4><br/>";

    $body .= "</form>";  
        
    $objPage->displayPage($body);
?>