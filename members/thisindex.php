<?php
    // put your code here
    session_start();    
    include_once 'memberMasterPage.php';
    require_once '../userInfoDB.php';
    require_once '../Database.php';
    require_once 'userStory.php';

    $success = '';
    $error = '';
    if (isset($_POST['message'])){
        //Validating inputs
    
        $message = $_POST['message'];
        $submitDate = $_POST['subdate'];
        $image = $_POST['image'];
        $storyTitle = $_POST['title']; 
            if (empty($message) || empty($image) || empty($submitDate) || empty ($storyTitle) ){
             $error = "All fields must to be filled properly prior to submission, Try Again!";
            
           } else {
             //add story to database
               $newstory = new userStory(); //This is to create the object of class userStory
               $row = $newstory->subStory($message, $submitDate, $image, $storyTitle); //This is to call the function subStory  of the class
               $success = "Your story has been submitted successfully!";
           } 
    }  
  
    // note for me(jassi): make the following code querystring based
    //$_SESSION['loginUserId'] = 4;
    //$_SESSION['userFName'] = "Tunde";
    
    if(!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])){
            header( 'Location: ../Login.aspx' ) ;
        }
 
        if(isset($_GET["searchUserId"])){
            $searchUserId = $_GET["searchUserId"]; // THIS WILL BE THE VALUE FROM QUERYSTRING
        }
        else {
            $searchUserId = $_SESSION['loginUserId'];
        }
 
        
        // ==================================== THIS CODE IS MUST  (START) ==============================================
        $objPage = new memberMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
        $objPage->setTitle('Zenith - User Story Submission Update'); 
        $objPage->setMetaAuthor('this is meta author');
        // ==================================== THIS CODE IS MUST  (END) ==============================================
  
        $body = "<form class='form-horizontal' method='post'>";
        $body .="<h1>My Success Story Submission</h1>";
        $body .= "<p> $success </p>";
        $body .= "<p> $error </p>";
        $body .="</form>";
        $objPage->displayPage($body);
        
?>        