<?php
    class adminNavigation{
        public function displayNavigation($roleId){
            $nav = "<div class='blog-masthead'><!-- Navigation starts here -->
                    <div class='container'>

                        <div class='navbar-header'>
                            <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>
                                <span class='sr-only'>Toggle navigation</span>
                                <span class='icon-bar'></span>
                                <span class='icon-bar'></span>
                                <span class='icon-bar'></span>
                            </button>
                            <a class='navbar-brand' href='#'></a> <!-- Acts as the logo as text -->
                        </div>

                        <div class='navbar-collapse collapse'>
                            <ul class='nav navbar-nav'>";
                            if($roleId == "1" || $roleId == 1)
                            {
                            $nav .= "<li><a href='membershipPlans.php'>Membership Plans</a></li>
                                    <li><a href='#'>Special Offers</a></li>
                                    <li class='dropdown'>
                                        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Success Stories<b class='caret'></b></a>
                                        <ul class='dropdown-menu'>
                                            <li><a href='./adminsuccessstoryapproved.php'>Approved Stories</a></li>
                                            <li><a href='./adminsuccessstory.php'>Submitted Stories</a></li>
                                        </ul>
                                    </li>
                                    <li class='dropdown'>
                                        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Support<b class='caret'></b></a>
                                        <ul class='dropdown-menu'>
                                            <li><a href='supportTickets.php'>Tickets</a></li>
                                            <li><a href='helpchatadmin.php'>Chat</a></li>
                                        </ul>
                                    </li>
                                    <li><a href='#'>FAQ</a></li>";
                            }
                            else if($roleId == "2" || $roleId == 2) {
                                $nav .= "
                                    <li class='dropdown'>
                                        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Support<b class='caret'></b></a>
                                        <ul class='dropdown-menu'>
                                            <li><a href='supportTickets.php'>Tickets</a></li>
                                            <li><a href='#'>Chat</a></li>
                                        </ul>
                                    </li>
                                    <li><a href='#'>Success Stories</a></li>
                                    <li><a href='#'>FAQ</a></li>";
                            }
                            $nav .= "</ul>
                        </div><!--/.nav-collapse -->
                    </div><!-- container ends -->
                </div><!-- Blog-masthead ends here -->";
            
            echo $nav;
        }
    }
?>