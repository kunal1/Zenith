<?php
    require_once '../Database.php';
    require_once '../members/userStory.php';

     
     
     $decisioninput = $_POST['isApproved']; 
     $storyy = $_POST['story_id'];
     //echo $_POST['story_id'];         
                     

     //echo $_POST['isApproved']. "<br/>";

     if ($decisioninput =='Approved'){
                        $decision = 0;
                    }
                    else {
                        $decision = 1;
                    }

    //echo $decision;
    $story = new userStory();
    $return = $story->approveStories($storyy,$decision);

    header ('location:../zenithadmin/adminsuccessstory.php');

    
?>