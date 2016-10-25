<?php
/*
 * @author Jagsir Singh
 */
class memberRightSideBar {
    //put your code here
    private $userId;

    public function __construct($userId){
        $this->userId = $userId;
    }
    public function displayRightSideBar()
    {
        include_once '../membershipPlansDB.php';    
        $objMemPlans = new membershipPlansDB();
        $allPlans = $objMemPlans->getMembershipPlans();

        $contents = "<div class='col-sm-3 blog-sidebar'>
                        <div class='sidebar-module sidebar-module-inset'>
                            <h4>Highlighted Profiles</h4>
                            <p><img src='../img/thumbnail.png' alt='success-story' class='img-thumbnail' class='img-thumbnail'>
                                <h4>Amta Russell</h4>
                                <p>Scarborough, Toronto</p>
                                <p><a href='#'>Send your Interest</a>  |  
                                <a href='#'>Send a Private Message</a>  |  
                                <a href='#'>Request contact details</a>
                            </p><br/>
                            <hr>";
        $contents .= "<br/>";
        if(count($allPlans)>0):
            $contents .= "<h4>Membership Plans</h4>";
            foreach($allPlans as $plan):
                $title = $plan['membership'];
                $time = $plan['daysAllowed'];
                $price = "$ " . $plan['price'];
                $contents .= "<strong>{$title}</strong><br />";
                $contents .= "Price: {$price} | Days: {$time}<br/>";
            endforeach;
        endif;
        $contents .= "                </div>
                    </div><!-- /.blog-sidebar -->";

        echo $contents;
    }
}
