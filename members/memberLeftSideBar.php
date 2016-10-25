<?php
/*
 * @author Jagsir Singh
 */
//require_once 'userInfoDB.php';
 require_once 'userImagesDB.php';
class memberLeftSideBar {
    //put your code here
    private $userId;
    
    public function __construct($userId){
        $this->userId = $userId;
    }
    public function displayLeftSideBar()
    {
        $userInfo = userInfoDB::getUserNameAddress($this->userId);
        $imageInfo = userImagesDB::getUserDefaultThumb($this->userId);
        $memInfo = userInfoDB::checkMembershipStatus($this->userId);
        
        if(count($imageInfo)>0)
        {
            if(empty($imageInfo[0]['thumbnail'])){     
                if($imageInfo[0]['gender'] == 'F'){
                    $thumbnailPath = '../images/default_FThumb.jpg';
                }
                else{
                    $thumbnailPath = '../images/default_MThumb.jpg';
                }
            }
            else{
                $thumbnailPath = '../' . $imageInfo[0]['thumbnail'];  
            }
        }
        else 
        {      
            if($imageInfo[0]['gender'] == 'F'){
                $thumbnailPath = '../images/default_FThumb.jpg';
            }
            else{
                $thumbnailPath = '../images/default_MThumb.jpg';
            }
        }
        
        $content = "<div class='col-sm-3  blog-sidebar'>
          <div class='sidebar-module'>
            <!-- <h4>User Details</h4> -->
            <p><img src='{$thumbnailPath}' alt='success-story' class='img-thumbnail' class='img-thumbnail'>
                <h4>{$userInfo[0]['firstName']} {$userInfo[0]['lastName']}  </h4>";
         if($userInfo[0]['city'] != null)
             {
                $content .= "<p>{$userInfo[0]['city']}, {$userInfo[0]['state']}</p>";
             }
         $content .= "<a href='profileImages.php'>Upload New Photo(s)</a> <br/>  
            <!-- <a href='#' class='active'>Edit your Details</a>  <br/> -->";
            if($memInfo[0]['member']=="1"): 
                $memID = $memInfo[0]['membershipId'];
                $content .= "<a href='../members/subscribe.php?memId={$memID}'>Renew Subcription</a> <br/>
                <a href='../members/userMemberships.php'>Change your Membership Plan</a><br />";
            endif;
             $content .= "<a href='#' id='delAccount'>Delete Account</a>";
              $content .= "<hr>
            <ol class='list-unstyled'>
              <li><a href='#'>View Requests</a></li>
              <li><a href='../members/memberinbox.php'>View Messages</a></li>
              <li><a href='../members/membersubmitstory.php'>Submit Your Story</a></li>
            </ol>
          </div><!-- sidebar module -->
        </div><!-- /.blog-sidebar -->";
                
        echo $content;
    }
}
