<?php
class publicMasterPage{
    private $meta_title;
    private $meta_keywords;
    private $meta_description;
    private $meta_author;
    private $page_heading;
    
    public function __construct(){
    }
    public function setTitle($title){
        $this->meta_title = $title;
    }    
    public function getTitle(){
        return $this->meta_title;
    }          
    public function setMetaKeywords($metakeywords){
        $this->meta_keywords = $metakeywords;
    }
    public function getMetaKeywords(){
        return $this->meta_keywords;
    }          
    public function setMetaDescription($metadescription){
        $this->meta_description = $metadescription;
    }
    public function getMetaDescription(){
        return $this->meta_description;
    }          
    public function setMetaAuthor($metaauthor){
        $this->meta_author = $metaauthor;
    }
    public function getMetaAuthor(){
        return $this->meta_author;
    }          
    public function setPageHeading($pageHeading){
        $this->page_heading = $pageHeading;
    }
    public function getPageHeading(){
        return $this->page_heading;
    }   
    
    public function displayPage($body){
        require_once 'LoginRegistration/core.php';
        require_once 'Database.php';
        if (isset($_GET['success']) && empty($_GET['success'])){ 
            header('Location: members/profile.php');
        }
        if(empty($errors) === false){
			echo '<p>' . implode('</p><p>', $errors) . '</p>';
		}
       
   
    if (isset($_POST['loginsubmit'])){

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            if (empty($username) === true || empty($password) === true)
                {
                    echo $errors[] = 'Sorry, but we need your username and password.';
                }
            else if ($userClass->user_exists($username) === false)
                {
                    echo $errors[] = 'Sorry that username doesn\'t exists.';
                }   
                else {
                    $login = $userClass->login($username, $password);
                    if ($login === false) {
                            echo $errors[] = 'Sorry, that username/password is invalid';
                    }else {
                            // username/password is correct and the login method of the $users object returns the user's id, which is stored in $login.

                            $_SESSION['loginUserId'] =  $login; // The user's id is now set into the user's session  in the form of $_SESSION['id'] 
                            $user = $userClass->userdata($_SESSION['loginUserId']);
                            $_SESSION['userFName'] = $user['firstName'].' '.$user['lastName']. '  ';
                            $roleId = $user['RoleId'];
                            #Redirect the user to Template.php.

                            switch ($roleId) 
                            {
                              case 1:
                              header('Location: zenithAdmin/specialOffers.php');
                              break;
                              case 2:
                              header('Location: zenithAdmin/supportTickets.php');
                              break;
                              case 3:
                              header('Location: members/profile.php');
                              break;
                            }

                            exit();
                    }
                }
    }             
                
                
       $page = '<!DOCTYPE html> <html  lang="en">
    	<head>
            <title>'.$this->getTitle().'</title>                  
            <meta charset="utf-8">
            <meta name="keywords" content="'.$this->getMetaKeywords().'" />  
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="'.$this->getMetaDescription().'" />  
            <meta name="author" content="'.$this->getMetaAuthor().'" />  
            <link rel="shortcut icon" href="assets/ico/favicon.ico">
            <!-- Bootstrap core CSS -->
            <link href="css/bootstrap.min.css" rel="stylesheet">
            <!-- Custom styles for this template -->
            <link href="styles/blog.css" rel="stylesheet">
    	</head>
    	<body>';
       //================== HEADER START =======================================
      $page .= "<div class='container'><!-- Container is a class used throughout the document -->
                <div id='logo'><a href='index.html'><img src='img/logo.png' alt='Zenith Matrimony'></a></div>
                <div id='login'>
                    <form method='post'>
                         <div class='form-group col-md-10'>
                              <div class='col-md-4'>
                                    <label class='control-label' for='username'>Username</label> 
                                    <input type='text' name='username' required >
                              </div>
                                  <div class='col-md-4'>
                                    <label class='control-label' for='password'>Password</label>
                                    <input type='password' name='password' required >
                                   </div>
                                     <div class='col-md-2'>
                                         <br>
                                    <input type='submit' name='loginsubmit' class='btn btn-success' value='Sign In'>
                                    </div>
                                 </div>
                        </form>
                </div>
            </div><!-- Container ends -->";
       //================== HEADER ENDS =======================================
      
       //================== NAVIGATION STARTS =======================================
    $page .= "<div class='blog-masthead'><!-- Navigation starts here -->
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
                    <li class='active'><a href='index.php'>Home</a></li>
                    <li><a href='aboutUs.php'>About</a></li>
                    <li><a href='contactUs.php'>Contact</a></li>
                    <li><a href='membershipPlans.php'>Membership</a></li>
                    <li><a href='#hot_offers'>Hot Offers</a></li>
                  </ul>
                </div><!--/.nav-collapse -->
              </div>
              </div>
           <!-- Navigation ends here -->";
       //================== NAVIGATION ENDS =======================================
    $page .= "<div class='container'><div class='row'>
        <div class='col-sm-12 blog-main'>
        <div class='blog-post'>";
    
#  ********************************  THIS IS MY CONTENT START *********************  
    $page .= $body;
#  ********************************   THIS IS MY CONTENT END  *********************  
    
    $page .= "</div></div>";
    $page .= "</div><!-- row -->
            </div><!-- /.container -->";
    
    $page .= "<div class='blog-footer'>
      <p> THIS IS A STUDENT PROJECT WEBSITE FOR HUMBER COLLEGE WEB DEV PROGRAM &copy; Team Zenith - All Rights Reserved 2014 </p>
      <p>
        <a href='#'>Back to top</a>
      </p>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
        <script src='js/bootstrap.min.js'></script>
        <script src='assets/js/docs.min.js'></script>
      </body>
    </html>";
    
    echo $page;
    }
}
?>