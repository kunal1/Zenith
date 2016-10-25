<?php
    echo "<div class='blog-masthead'><!-- Navigation starts here -->
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
          <ul class='nav navbar-nav'>
            <li><a href='../members/profile.php'>Home</a></li>
            <li><a href='../members/memberinbox.php'>Inbox</a></li>
            <li><a href='../members/memberpmsend.php'>Send Message</a></li>
            <li class='dropdown'>
              <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Search <b class='caret'></b></a>
              <ul class='dropdown-menu'>
                <li><a href='#'>Search by Id</a></li>
                <li><a href='../search/regularSea.php'>Regular Search</a></li>
              </ul>
            </li>
            <li class='dropdown'>
              <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Upgrade <b class='caret'></b></a>
              <ul class='dropdown-menu'>
                <li><a href='../members/userMemberships.php'>Membership Plans</a></li>
                <li><a href='../members/userOffers.php'>Special Offers</a></li>
              </ul>
            </li>
            <li class='dropdown'>
              <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Support <b class='caret'></b></a>
              <ul class='dropdown-menu'>
                <li><a href='../members/supportTickets.php'>Tickets</a></li>
                <li><a href='helpchat.php'>Chat</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div><!-- container ends -->
    </div><!-- Blog-masthead ends here -->";
?>