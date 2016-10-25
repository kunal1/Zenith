<?php
require_once '../userInfoDB.php';
class memberMasterPage {
    private $meta_title;
    private $meta_keywords;
    private $meta_description;
    private $meta_author;
    private $html_body;
    private $page_heading;
    private $userId;

    public function __construct($userId){
        $this->userId = $userId;
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
    
    public function getBody(){
        return $this->html_body;
    }
    public function setBody($pageBody){
        $this->html_body = $pageBody;
    }
    
    private function intializePaze(){
        $initial = '<!DOCTYPE html> <html  lang="en">
    	<head>
            <title>'.$this->getTitle().'</title>                  
            <meta charset="utf-8">
            <meta name="keywords" content="'.$this->getMetaKeywords().'" />  
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="'.$this->getMetaDescription().'" />  
            <meta name="author" content="'.$this->getMetaAuthor().'" />  
            <link rel="shortcut icon" href="../assets/ico/favicon.ico">
            <!-- Bootstrap core CSS -->
            <link href="../css/bootstrap.min.css" rel="stylesheet">

            <!-- Custom styles for this template -->
            <link href="../styles/blog.css" rel="stylesheet">
 <link href="../styles/RegularSearch.css" rel="stylesheet">
            <link href="../styles/tickets.css" rel="stylesheet">
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../assets/js/docs.min.js"></script>
            <script type="text/javascript" src="../js/profile.js"></script>
                        <script type="text/javascript" src="../js/regularSearch.js"></script>

    	</head>
    	<body>';
        echo $initial;
    }
    private function displayHeader(){
        include_once 'memberHeader.php';
        $objHead = new memberHeader();
        $objHead->displayHeader();
    }    
    private function displayNavigation(){
        include_once 'memberNavigation.php';
    }    
    private function startBodyContent()    {
        echo "<div class='container'><div class='row'>";
    }
    private function displayLeftSideBar(){
        include_once 'memberLeftSideBar.php';
        $objLSide = new memberLeftSideBar($this->userId);
        $objLSide->displayLeftSideBar();
    }
    private function displayRightSideBar(){
        include_once 'memberRightSideBar.php';
        $objRSide = new memberRightSideBar($this->userId);
        $objRSide->displayRightSideBar();
    }
    private function endBodyContent()    {
        echo "</div><!-- row -->
            </div><!-- /.container -->";
    }
    private function displayFooter(){
        include_once 'memberFooter.php';
    }    
    private function endPage(){
        $end =   '</body>
    	</html>';        
        echo $end;
    }
    
    public function displayPage($body) {
        $this->intializePaze();
        $this->displayHeader();
        $this->displayNavigation();
        $this->startBodyContent();
        $this->displayLeftSideBar();
       ?>
        <div class="col-sm-6 blog-main">
        <div class="blog-post">
        <?php
      #  ********************************  THIS IS MY CONTENT START *********************  
              echo $body;
      #  ********************************   THIS IS MY CONTENT END  *********************  
        ?></div></div>
      <?php
        $this->displayRightSideBar();
        $this->endBodyContent();
        $this->displayFooter();
        $this->endPage();
    }
    
}
?>
