<?php
    session_start();    
    include_once '../Database.php';
    include_once './adminMasterPage.php';
    include_once '../members/userstory.php';
    
    
    if(!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])){
            header( 'Location: ../Login.aspx' ) ;
        }
        
        
    // ==================================== THIS CODE IS MUST  (START) =============================================================
    $objPage = new adminMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
    $objPage->setTitle('Zenith - Approved Success Stories'); 
    $objPage->setMetaAuthor('Tunde Obatayo');
    // ==================================== THIS CODE IS MUST  (END) =================================================================
    
    $story = new userStory();

    $allstories = $story->getAllAdminApproveStories();
    
    $body = '<h2>Story list</h2>';
    $body .= '<table class="table-striped table-bordered">';
    $body .= '<tr>';
    $body .= '<th>Title</th>';        
    $body .= '<th>Message</th>';
    $body .= '<th>Date</th>';
    $body .= ' <th>State</th>';
    $body .= '<th>&nbsp;</th>';
    $body .= '</tr>';
    foreach($allstories as $story):

    $title = $story['storyTitle'];
    $message = $story['message'];
    $date = $story['submitDate'];

    $body .= '<tr>';
    $body .= "<td>$title</td>";      
    $body .= "<td>$message</td>";
    $body .= "<td>$date</td>";

    if ($story['isApproved']==1){
    $story['isApproved'] = 'Approved';
     }
    else if ($story['isApproved']==0){
    $story['isApproved'] = 'Not Approved';      
    }
    $decision = $story['isApproved'];

    $storyID = $story['successStoryId'];
   

    $body .= "<td>{$decision}</td>";
    $body .= '<td>';
    $body .= '<form action="switchdecision.php" method="post" id="update_storylist_form">';
    $body .= "<input type='hidden' name='story_id' value='{$storyID}'/>";                    
    $body .= "<input type='hidden' name='isApproved' value='{$decision}'/>";
    $body .= '<input type="submit" value="Switch"/>';
    $body .= '</form>';
    $body .= '</td>';
    $body .= '</tr>';
    endforeach;
    $body .='</table>';
        
   
       
 $objPage->displayPage($body);
    
?>