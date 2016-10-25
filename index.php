<?php
require 'LoginRegistration/core.php';
//$generalClass->logged_in_protect();
    session_start();    
require_once './members/userStory.php';
require_once 'Database.php';

$conn= Database::getCountries();   //to get list of countries
$country_val="<option></option>";
for ($i = 0; $i < count($conn); $i++) {
    $country_val.="<option>" . $conn[$i]['country'] . "</option>";
}
/* @var $con type */
    $con = Database::getRe();
    $religion_val="<option></option>";
for ($i = 0; $i < count($con); $i++) {
    $religion_val.="<option>" . $con[$i]['religion'] . "</option>";
}

    
$story = new userStory();
$result = $story->getApprovedStories();
 

if (isset($_POST['submitbutton'])) {
 
    $selected_radio = $_POST['sexradios'];
    $religionindex = $_POST['religions'];
	if(empty($_POST['textfirst']) || empty($_POST['textlast']) || empty($_POST['email']) || empty($_POST['passwordinput']) ||
                empty($_POST['username'])){
 
		$errors[] = 'All fields are required.';
 
	}else{
        
        #validating user's input with functions that we will create next
        if ($userClass->user_exists($_POST['username']) === true) {
            $errors[] = 'That username already exists';
        }
        if(!ctype_alnum($_POST['username'])){
            $errors[] = 'Please enter a username with only alphabets and numbers';	
        }
        if (strlen($_POST['passwordinput']) <6){
            $errors[] = 'Your password must be at least 6 characters';
        } else if (strlen($_POST['passwordinput']) >18){
            $errors[] = 'Your password cannot be more than 18 characters long';
        }
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Please enter a valid email address';
        }else if ($userClass->email_exists($_POST['email']) === true) {
            $errors[] = 'That email already exists.';
        }
	}
 
	if(empty($errors) === true){
		
                $textfirst = htmlentities($_POST['textfirst']);
                $textlast = htmlentities($_POST['textlast']);
		$username = htmlentities($_POST['username']);
		$password = $_POST['passwordinput'];
		$email = htmlentities($_POST['email']);
                $selected_radio = $_POST['sexradios'];
                $age = $_POST['age'];
 
		$userClass->register($textfirst,$textlast,$username, $password, $email,$selected_radio,$age);// Calling the register function, which we will create soon.
		header('Location:index.php?success');
		exit();
	}
}
 
if (isset($_GET['success']) && empty($_GET['success'])) 
    {
 
  header('Location: members/profile.php');
}
		# if there are errors, they would be displayed here.
		
 


//if (empty($_POST) === false) 
if (isset($_POST['loginsubmit'])) 
{
 
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
 
	if (empty($username) === true || empty($password) === true)
            {
		$errors[] = 'Sorry, but we need your username and password.';
            }
	else if ($userClass->user_exists($username) === false)
            {
		 $errors[] = 'Sorry that username doesn\'t exists.';
            }
//	 else if ($userClass->email_confirmed($username) === false) {
//		$errors[] = 'Sorry, but you need to activate your account. 
//					 Please check your email.';
//	} 
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
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      
<script>
  $(document).ready(function() {
    $("#religion").change(function(){
      $("#religion_hidden").val(("#religion").find(":selected").text());
    });
  });
</script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../project2/docs/examples/blog/assets/ico/favicon.ico">

    <title>Zenith Matrimony</title>
    <script type="text/javascript">
    <!--
    var img1 = new Image()
    img1.src = "img/slide1.jpg"
    var img2 = new Image()
    img2.src = "img/slide2.jpg"
    var img3 = new Image()
    img3.src = "img/slide3.jpg"
    
    //-->
    </script>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="styles/blog.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container"><!-- Container is a class used throughout the document -->
        
        <a href="index.html"><img src="img/logo.png" alt="Zenith Matrimony" id="logo" /></a>
       
    <div id="login">
        <form method="post" action="">
             <div class="form-group col-md-10">
                 <?php if(empty($errors) === false)
                     {
			echo '<p>' . implode('</p><p>', $errors) . '</p>';
		     } ?>
                  <div class="col-md-4">
                        <label class="control-label" for="username">Username</label> 
			<input type="text" name="username" required >
		  </div>
                      <div class="col-md-4">
                        <label class="control-label" for="password">Password</label>
			<input type="password" name="password" required >
                       </div>
                         <div class="col-md-2">
                             <br>
			<input type="submit" name="loginsubmit" class="btn btn-success" value="Sign In">
                        </div>
                     </div>
            </form>
    </div>
    
    </div>
<!--        <form action="" method="POST" >
        <div class="form-group col-md-12">
            
            
      <div class="col-md-5">
 <label class="control-label" for="email">Email</label>  
 <input id="email" name="email" placeholder="functional@email.com" class="form-control input-md input-lg" required type="text"> 
      </div>
      <div class="col-md-5">
  <label class="control-label" for="passwordinput">Password</label>
  <input id="passwordinput" name="passwordinput" placeholder="******" class="form-control input-md input-lg" required type="password">
  
      </div>
      <div class="col-md-2">
          <br>
    <input  type="submit" class="btn btn-success" value="Sign In" name="Submit" ID="Submit">
      </div>
    </div>
 </form>-->

    
    <div class="blog-masthead"><!-- Navigation starts here -->
      <div class="container">
      
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"></a> <!-- Acts as the logo as text -->
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="aboutUs.php">About</a></li>
            <li><a href="contactUs.php">Contact</a></li>
            <li><a href="membershipPlans.php">Membership</a></li>
            <li><a href="#hot_offers">Hot Offers</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
      </div>
   <!-- Navigation ends here -->

    <div class="container">

     <div class="row">
        <div class="col-sm-8 blog-main">
        <div id="slider">
          <img src="img/slide1.jpg" class="img-responsive" name="slide" />
   
            <script type="text/javascript">
	        <!--
            var pic = 1;
            function show() {
            if (!document.images)
            return
            document.images.slide.src=eval("img"+pic+".src")
            if (pic < 3)
            pic++
            else
            pic = 1
            setTimeout ("show()",3000)
            }
            show()
	        //-->
            </script>
            </div>
          <div class="blog-post">
          <div class="panel">
          <div class="panel-body">
          <h3>Success Stories</h3>
             <?php foreach ($result as $value): ?>
             <div class="blog row"> 
              <h4><?php echo $value['storyTitle']; ?></h4>
              <p><img src="<?php echo $value['imageName'];?>" alt="successstory" class="imgstory"/><?php echo $value['message']. "<br/><br/>"; ?></p>
              </div>
                      
              <?php endforeach; ?>  
              <p align="center"><a href="./members/membersubmitstory.php">Submit Your Success Story</a></p>  
      </div>
      </div>
      </div><!-- /.blog-main --> 
      </div><!-- /col sm-8 -->

        <div class="col-sm-4 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
              <form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Form Name -->
<legend>Register</legend>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Name</label>  
  <div class="col-md-8">
  <input id="textinput" name="textfirst" placeholder="First Name" class="form-control input-md input-lg" type="text"> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Surname</label>  
  <div class="col-md-8">
  <input id="textinput" name="textlast" placeholder="Last Name" class="form-control input-md input-lg" type="text"> 
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Username</label>  
  <div class="col-md-8">
  <input id="textinput" name="username" placeholder="Second name" class="form-control input-md input-lg" type="text"> 
  </div>
</div>
<br>
<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="sexradios">Sex</label>
  <div class="col-md-8"> 
    <label class="radio-inline" for="sexradios-0">
      <input name="sexradios" id="sexradios-0" value="M" checked="checked" type="radio">
      Male
    </label> 
    <label class="radio-inline" for="sexradios-1">
      <input name="sexradios" id="sexradios-1" value="F" type="radio">
      Female
    </label>
  </div>
</div>

<br>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Age</label>  
  <div class="col-md-8">
  <input id="textinput" name="age" placeholder="Put your age here" class="form-control input-md input-lg" type="text"> 
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>  
  <div class="col-md-8">
  <input id="email" name="email" placeholder="functional@email.com" class="form-control input-md input-lg" required type="text"> 
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="passwordinput">Password</label>
  <div class="col-md-8">
    <input id="passwordinput" name="passwordinput" placeholder="******" class="form-control input-md input-lg" required type="password">
    
  </div>
</div>

<!--<div class="form-group">
  <label class="col-md-4 control-label" for="confirmpasswordinput">Confirm Password</label>
  <div class="col-md-8">
    <input id="confirmpasswordinput" name="confirmpasswordinput" placeholder="******" class="form-control input-md input-lg" required type="password">
    
  </div>
</div>-->

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="religion">Religion</label>
  <div class="col-md-8">
      
       <select id="religion" name="religion" class="form-control input-lg input-sm">
                                <?php
                                echo $religion_val;
                                ?>
                </select>
<!--    <select id="religion" name="religion" class="form-control input-lg input-sm">
      <option value="1">Ayyavazhi</option>
      <option value="2">Atheist</option>
      <option value="3">Agnostic</option>
      <option value="4">Christian - Orthodox</option>
      <option value="5">Christian - Protestant</option>
      <option value="6">Christian - Catholic</option>
      <option value="7">Christian - Others</option>
      <option value="8">Hindu</option>
      <option value="9">Muslim - Shia</option>
      <option value="10">Muslim - Sunni</option>
      <option value="11">Muslim - Others</option>
      <option value="12">Sikh</option>
      <option value="13">Jain - Digambar</option>
      <option value="14">Jain - Shwetambar</option>
      <option value="15">Jain - Others</option>
      <option value="16">Parsi</option>
      <option value="17">Buddhist</option>
      <option value="18">Inter - Religion</option>
    </select>-->
      <input type="hidden" name="religions" id="religion_hidden">
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="lanuage">Language</label>  
  <div class="col-md-8">
  <input id="lanuage" name="lanuage" placeholder="" class="form-control input-md input-lg" required type="text">  
  </div>
</div>

<!-- Button Drop Down -->
<div class="form-group">
<label class="col-md-4 control-label" for="country">Country</label>
  <div class="col-md-8">
<!--    <select id="country" name="country" class="form-control input-lg">
          <option value="1">Afghanistan</option>
          <option value="2">Albania</option>
          <option value="3">Algeria</option>
          <option value="4">Andorra</option>
          <option value="5">Angola</option>
          <option value="6">Antigua and Barbuda</option>
          <option value="7">Argentina</option>
          <option value="8">Armenia</option>
          <option value="9">Aruba</option>
          <option value="10">Australia</option>
          <option value="11">Austria</option>
          <option value="12">Azerbaijan</option>
          <option value="13">Bahamas, The</option>
          <option value="14">Bahrain</option>
          <option value="15">Bangladesh</option>
          <option value="16">Barbados</option>
          <option value="17">Belarus</option>
          <option value="18">Belgium</option>
          <option value="19">Belize</option>
          <option value="20">Benin</option>
          <option value="21">Bhutan</option>
          <option value="22">Bolivia</option>
          <option value=" ">Bosnia and Herzegovina</option>
          <option value=" ">Botswana</option>
          <option value=" ">Brazil</option>
          <option value=" ">Brunei</option>
          <option value=" ">Bulgaria</option>
          <option value=" ">Burkina Faso</option>
          <option value=" ">Burma</option>
          <option value=" ">Cambodia</option>
          <option value=" ">Cameroon</option>
          <option value=" ">Canada</option>
          <option value=" ">Cape Verde</option>
          <option value=" ">Central African Republic</option>
          <option value=" ">Chad</option>
          <option value=" ">Chile</option>
          <option value=" ">China</option>
          <option value=" ">Colombia</option>
          <option value=" ">Comoros</option>
          <option value=" ">Congo, Democratic Republic of the</option>
          <option value=" ">Congo, Republic of the</option>
          <option value=" ">Costa Rica</option>
          <option value=" ">Cote d'Ivoire</option>
          <option value=" ">Croatia</option>
          <option value=" ">Cuba</option>
          <option value=" ">Curacao</option>
          <option value=" ">Cyprus</option>
          <option value=" ">Czech Republic</option>
          <option value=" ">Denmark</option>
          <option value=" ">Djibouti</option>
          <option value=" ">Dominica</option>
          <option value=" ">Dominican Republic</option>
          <option value=" ">East Timor</option>
          <option value=" ">Ecuador</option>
          <option value=" ">Egypt</option>
          <option value=" ">El Salvador</option>
          <option value=" ">Equatorial Guinea</option>
          <option value=" ">Eritrea</option>
          <option value=" ">Estonia</option>
          <option value=" ">Ethiopia</option>
          <option value=" ">Fiji</option>
          <option value=" ">Finland</option>
          <option value=" ">France</option>
          <option value=" ">Gabon</option>
          <option value=" ">Gambia, The</option>
          <option value=" ">Georgia</option>
          <option value=" ">Germany</option>
          <option value=" ">Ghana</option>
          <option value=" ">Greece</option>
          <option value=" ">Grenada</option>
          <option value=" ">Guatemala</option>
          <option value=" ">Guinea</option>
          <option value=" ">Guinea-Bissau</option>
          <option value=" ">Guyana</option>
          <option value=" ">Haiti</option>
          <option value=" ">Holy See</option>
          <option value=" ">Honduras</option>
          <option value=" ">Hong Kong</option>
          <option value=" ">Hungary</option>
          <option value=" ">Iceland</option>
          <option value=" ">India</option>
          <option value=" ">Indonesia</option>
          <option value=" ">Iran</option>
          <option value=" ">Iraq</option>
          <option value=" ">Ireland</option>
          <option value=" ">Israel</option>
          <option value=" ">Italy</option>
          <option value=" ">Jamaica</option>
          <option value=" ">Japan</option>
          <option value=" ">Jordan</option>
          <option value=" ">Kazakhstan</option>
          <option value=" ">Kenya</option>
          <option value=" ">Kiribati</option>
          <option value=" ">Korea, North</option>
          <option value=" ">Korea, South</option>
          <option value=" ">Kosovo</option>
          <option value=" ">Kuwait</option>
          <option value=" ">Kyrgyzstan</option>
          <option value=" ">Laos</option>
          <option value=" ">Latvia</option>
          <option value=" ">Lebanon</option>
          <option value=" ">Lesotho</option>
          <option value=" ">Liberia</option>
          <option value=" ">Libya</option>
          <option value=" ">Liechtenstein</option>
          <option value=" ">Lithuania</option>
          <option value=" ">Luxembourg</option>
          <option value=" ">Macau</option>
          <option value=" ">Macedonia</option>
          <option value=" ">Madagascar</option>
          <option value=" ">Malawi</option>
          <option value=" ">Malaysia</option>
          <option value=" ">Maldives</option>
          <option value=" ">Mali</option>
          <option value=" ">Malta</option>
          <option value=" ">Marshall Islands</option>
          <option value=" ">Mauritania</option>
          <option value=" ">Mauritius</option>
          <option value=" ">Mexico</option>
          <option value=" ">Micronesia</option>
          <option value=" ">Moldova</option>
          <option value=" ">Monaco</option>
          <option value=" ">Mongolia</option>
          <option value=" ">Montenegro</option>
          <option value=" ">Morocco</option>
          <option value=" ">Mozambique</option>
          <option value=" ">Namibia</option>
          <option value=" ">Nauru</option>
          <option value=" ">Nepal</option>
          <option value=" ">Netherlands</option>
          <option value=" ">Netherlands Antilles</option>
          <option value=" ">New Zealand</option>
          <option value=" ">Nicaragua</option>
          <option value=" ">Niger</option>
          <option value=" ">Nigeria</option>
          <option value=" ">Norway</option>
          <option value=" ">Oman</option>
          <option value=" ">Pakistan</option>
          <option value=" ">Palau</option>
          <option value=" ">Palestinian Territories</option>
          <option value=" ">Panama</option>
          <option value=" ">Papua New Guinea</option>
          <option value=" ">Paraguay</option>
          <option value=" ">Peru</option>
          <option value=" ">Philippines</option>
          <option value=" ">Poland</option>
          <option value=" ">Portugal</option>
          <option value=" ">Qatar</option>
          <option value=" ">Romania</option>
          <option value=" ">Russia</option>
          <option value=" ">Rwanda</option>
          <option value=" ">Saint Kitts and Nevis</option>
          <option value=" ">Saint Lucia</option>
          <option value=" ">Saint Vincent and the Grenadines</option>
          <option value=" ">Samoa</option>
          <option value=" ">San Marino</option>
          <option value=" ">Sao Tome and Principe</option>
          <option value=" ">Saudi Arabia</option>
          <option value=" ">Senegal</option>
          <option value=" ">Serbia</option>
          <option value=" ">Seychelles</option>
          <option value=" ">Sierra Leone</option>
          <option value=" ">Singapore</option>
          <option value=" ">Sint Maarten</option>
          <option value=" ">Slovakia</option>
          <option value=" ">Slovenia</option>
          <option value=" ">Somalia</option>
          <option value=" ">South Africa</option>
          <option value=" ">South Sudan</option>
          <option value=" ">Spain</option>
          <option value=" ">Sri Lanka</option>
          <option value=" ">Sudan</option>
          <option value=" ">Suriname</option>
          <option value=" ">Swaziland</option>
          <option value=" ">Sweden</option>
          <option value=" ">Switzerland</option>
          <option value=" ">Syria</option>
          <option value=" ">Taiwan</option>
          <option value=" ">Tajikistan</option>
          <option value=" ">Tanzania</option>
          <option value=" ">Thailand</option>
          <option value=" ">Togo</option>
          <option value=" ">Tonga</option>
          <option value=" ">Trinidad and Tobago</option>
          <option value=" ">Tunisia</option>
          <option value=" ">Turkey</option>
          <option value=" ">Turkmenistan</option>
          <option value=" ">Tuvalu</option>
          <option value=" ">Uganda</option>
          <option value=" ">Ukraine</option>
          <option value=" ">United Arab Emirates</option>
          <option value=" ">United Kingdom</option>
          <option value=" ">Uruguay</option>
          <option value=" ">Uzbekistan</option>
          <option value=" ">Vanuatu</option>
          <option value=" ">Venezuela</option>
          <option value=" ">Vietnam</option>
          <option value=" ">Yemen</option>
          <option value=" ">Zambia</option>
          <option value=" ">Zimbabwe</option>
    </select>-->
               <select id="country" name="country" class="form-control input-lg">
                                <?php
                                echo $country_val;
                                ?>
                </select>

  </div>
</div>

<!-- Multiple Checkboxes (inline)
<div class="form-group">
  <label class="col-md-3 control-label" for="account">Plan</label>
  <div class="col-md-9">
    <label class="checkbox-inline" for="account-1">
      <input name="account" id="account-1" value="1" type="checkbox">
      Gold
    </label>
    <label class="checkbox-inline" for="account-2">
      <input name="account" id="account-2" value="2" type="checkbox">
      Silver
    </label>
    <label class="checkbox-inline" for="account-3">
      <input name="account" id="account-3" value="3" type="checkbox">
      Bronze
    </label>
  </div>
</div> -->

<!-- Button (Submit) -->
<div class="form-group">
  
  <div class="col-md-12" align="right">
      <input type="submit" id="submitbutton" name="submitbutton" class="btn btn-success" value="Register">
  </div>
</div>

</fieldset>
</form>
 </div>
 </div>
 </div><!-- /.row -->

 <div class="row">
      <h3>Newest Members</h3>
      <div class="col-sm-3">
      <p><img src="img/success1.jpg" alt="success-story" class="img-thumbnail" class="img-thumbnail"><h4>Amta Bhancha</h4><p>Scarborough, Toronto</p></div>
          <div class="col-sm-3">
          <p><img src="img/success1.jpg" alt="success-story" class="img-thumbnail" class="img-thumbnail"><h4>Sexy flirt 21</h4><p>Woodbridge, Toronto</p></div>
              <div class="col-sm-3">
  <p><img src="img/success1.jpg" alt="success-story" class="img-thumbnail" class="img-thumbnail"><h4>Lady's Man</h4><p>Dallas, USA</p></div>
              <div class="col-sm-3">
              <p><img src="img/success1.jpg" alt="success-story" class="img-thumbnail" class="img-thumbnail"><h4>Trojan Horse</h4><p>GTA, Toronto</p></div>
              </div>
              </div><!-- row -->
  <!-- /.container -->

    <div class="blog-footer">
      <p> THIS IS A STUDENT PROJECT WEBSITE FOR HUMBER COLLEGE WEB DEV PROGRAM &copy; Team Zenith - All Rights Reserved 2014 </p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="assets/js/docs.min.js"></script>
  </body>
</html>

