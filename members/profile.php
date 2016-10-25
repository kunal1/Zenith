<?php
    // put your code here
    session_start();    
    include_once 'memberMasterPage.php';
    include_once '../userInfoDB.php';
    include_once '../commonDB.php';
 
 // note for me(jassi): make the following code querystring based
//    $_SESSION['loginUserId'] = 4;
//    $_SESSION['userFName'] = "Tunde";
    
    
    
    
    if(!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])){
            header( 'Location: ../index.php' ) ;
        }
 
        if(isset($_GET["searchUserId"])){
            $searchUserId = $_GET["searchUserId"]; // THIS WILL BE THE VALUE FROM QUERYSTRING
        }
        else {
            $searchUserId = $_SESSION['loginUserId'];
        }
        
      
 
        
        // ==================================== THIS CODE IS MUST  (START) ==============================================
        $objPage = new memberMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
        $objPage->setTitle('Zenith - Profile'); 
        $objPage->setMetaAuthor('this is meta author');
        // ==================================== THIS CODE IS MUST  (END) ==============================================
        
        $objUsers = new userInfoDB();
  
        $personalAcc = false;
        $act = '';
        if($searchUserId == $_SESSION['loginUserId']){
            $personalAcc = true;
            
            if(isset($_GET['actEdit'])){
                $act = $_GET['actEdit'];
            }
        }
        
        $UserBInfo = $objUsers->getUserDetailsById($searchUserId, $_SESSION['loginUserId']);
        if(count($UserBInfo)>0){
            $UserFDet = $objUsers->getUserFamilyDetails($searchUserId);
            $UserHobbies = $objUsers->getUserHobbies($searchUserId);
            $UserLocation = $objUsers->getUserLocation($searchUserId);
            $UserPPref = $objUsers->getUserPartnerPref($searchUserId);
            $UserProf = $objUsers->getUserProfession($searchUserId);

            $body = "<form class='form-horizontal' method='post'>";
            $body .= "<link href='../styles/profiles.css' rel='stylesheet'>";
            $body .= "<div id='overlay'></div>";
            $body .= "<input type='hidden' id='hdUId' name='hdUId' value='{$_SESSION['loginUserId']}'>";
            $body .= "<input id='hdnSearchUserId' type='hidden' value='{$searchUserId}'/>";
            $body .= "<label style='color:Red;' name='lblMsg' id='lblMsg'></label><br/>";
            $body .= "<br/>";
      //=========================== A FEW WORDS ABOUT ME AND BASIC INFO SECTIONS [STARTS HERE]==================================
                $firstName = $UserBInfo[0]['firstName'];
                $lastName = $UserBInfo[0]['lastName'];
                $email = $UserBInfo[0]['email'];
                $gender = $UserBInfo[0]['gender'];
                $age = $UserBInfo[0]['age'];
                $dob = $UserBInfo[0]['dateOfBirth'];
                $thumbnail = $UserBInfo[0]['thumbnail'];
                $isMember = $UserBInfo[0]['member'];
                $contactsLeft  = $UserBInfo[0]['leftContacts'];

                if(empty($firstName)){
                    $firstName = '---';
                }
                if(empty($lastName)){
                    $lastName = '---';
                }
                if(empty($email)){
                    $email = '---';
                }
                if(empty($gender)){
                    $gender = '---';
                }
                if(empty($age)){
                    $age = '---';
                }
                if(empty($dob)){
                    $dob = '---';
                }
                if(empty($thumbnail)){
                    if($gender == 'F'){
                        $thumbnail = 'images/default_FThumb.jpg';
                    }
                    else{
                        $thumbnail = 'images/default_MThumb.jpg';
                    }
                }

                $createsFor = $UserBInfo[0]['createsFor'];
                $aboutUser = $UserBInfo[0]['aboutUser'];
                $bodyType = $UserBInfo[0]['bodyType'];
                $complexion = $UserBInfo[0]['complexion'];
                $physicalStatus = $UserBInfo[0]['physicalStatus'];
                $height = $UserBInfo[0]['height'];
                $weight = $UserBInfo[0]['weight'];
                $motherTounge = $UserBInfo[0]['motherTounge'];
                $martialStatus = $UserBInfo[0]['martialStatus'];
                $drinkHabits = $UserBInfo[0]['drinkHabits'];
                $smokeHabits = $UserBInfo[0]['smokeHabits'];
                $eatingHabits = $UserBInfo[0]['eatingHabits'];
                $hairColor = $UserBInfo[0]['hairColor'];
            if($personalAcc){
                $body .= "<div  class='form-group'>";
                $body .= "<br /><h3><strong>A few words about ";  
                if($createsFor == "self"){
                  $body .= "me</strong></h3>";
                }
                else    {
                  $body .= "my " . $createsFor ."</strong></h3>";
                }  
                $body .= $aboutUser;
//                $body .= "<div class='col-md-12' align='right'><a href='#' id='delAccount'>Delete Account</a><hr /></div>";
                $body .= "</div>";
            }
            else {
                $body .= "<div  class='form-group'>";
                $body .= "<table id='tblContact'><tr>";
                $pageName = "Gallary";
                $body .= "<td><a href='#' id='viewGallary'><img src='../{$thumbnail}' alt='{$firstName}' class='img-thumbnail' class='img-thumbnail'></a></td>";
                $body .= "<td>";
                $body .= "<table>";
                $body .= "<tr><td>Name: </td><td>" . $firstName . " " . $lastName . "</td></tr>";
                $body .= "<tr><td>Age: </td><td>" . $age . "</td></tr>";
                $body .= "<tr><td>Date of Birth: </td><td>" . $isMember . "</td></tr>";
                if(!empty($isMember))
                {
                    if($contactsLeft > 0)
                    {    
                        $body .= "<tr><td colspan='2'>";
                        $body .= "<div id='divHide'>";
                        $body .= "<div id='divContact'></div><input type='submit' id='btnCloseContact' class='btn btn-warning tmpClose' value='Close'/>";
                        $body .= "</div>";
                        $body .= "</td></tr>";    
                        $body .= "<tr>";
                        $body .= "<div id='divContShow'><td>";
                        $body .= "<input type='submit' id='viewContact' class='btn btn-success' value='View Contact'/></td>";
                        $body .= "<td><input type='submit' id='chat' class='btn btn-success' value='Chat'/>";
                        $body .= "</td></div>";
                        $body .= "</tr>";            
                    } 
                }
                $body .= "</table>";
                $body .= "</td>";
                $body .= "</tr></table>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<br /><h3><strong>A few words about ";  
                $body .= $firstName ."</strong></h3>";
                $body .= "</div>";
            }

            $body .= "<div id='simpleDivBasicDet'>";   
                $body .= "<div  class='form-group'>";
                $body .= "<table style='width: 100%;'><tr><td><h3><strong>Basic Info</strong></h3></td>";    
                $body .= "<td style='text-align: right;'>"; 
                if($personalAcc){
                    $body .= "<a href='#' id='basicEdit'>Edit</a>";
                }
                $body .= "</td></tr></table>"; 
                $body .= "</div>";
                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Body Type:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblBodyType' name='lblBodyType' style='font-weight: normal;'>{$bodyType}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Complexion:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblComplexion' name='lblComplexion' style='font-weight: normal;'>{$complexion}</label>";
                $body .= "</div>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Physical Status:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblPStatus' name='lblPStatus' style='font-weight: normal;'>{$physicalStatus}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Martial Status:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblMStatus' name='lblMStatus' style='font-weight: normal;'>{$martialStatus}</label>";
                $body .= "</div>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Weight:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblWeight' name='lblWeight' style='font-weight: normal;'>{$weight}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Height:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblHeight' name='lblHeight' style='font-weight: normal;'>{$height}</label>";
                $body .= "</div>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Smoke Habits:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblSHabits' name='lblSHabits' style='font-weight: normal;'>{$smokeHabits}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Eating Habits:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblEHabits' name='lblEHabits' style='font-weight: normal;'>{$eatingHabits}</label>";
                $body .= "</div>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Drink Habits:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblDHabits' name='lblDHabits' style='font-weight: normal;'>{$drinkHabits}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Mother Tongue:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblMTongue' name='lblMTongue' style='font-weight: normal;'>{$motherTounge}</label>";
                $body .= "</div>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Hair Color:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblHColor' name='lblHColor' style='font-weight: normal;'>{$hairColor}</label>";
                $body .= "</div>";
                $body .= "</div>";
            $body .= "</div>";                   
            if($personalAcc){
                   $body .= "<div id='editDivBasicDet'>";
                        $body .= "<div  class='form-group'>";
                        $body .= "<table style='width: 100%;'><tr><td><h3><strong>Basic Info</strong></h3></td>";    
                        $body .= "<td style='text-align: right;'>"; 
                        $body .= "</td></tr></table>"; 
                        $body .= "</div>";
                        $body .= "<div  class='form-group'>";
                        $body .= "<label class='col-md-4 control-label'>Body Type:</label>";
                        $body .= "<div class='col-md-8'>";
                        $body .= "<label  class='radio-inline'><input name='rdbBodyType' value='Slim' type='radio'> Slim</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbBodyType' value='Athletic' type='radio'> Athletic</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbBodyType' value='Average' type='radio'> Average</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbBodyType' value='Heavy' type='radio'> Heavy</label>";
                        $body .= "</div>";            
                        $body .= "</div>";

                        $body .= "<div  class='form-group'>";
                        $body .= "<label class='col-md-4 control-label'>Complexion:</label>";
                        $body .= "<div class='col-md-8'>";
                        $body .= "<label  class='radio-inline'><input name='rdbComplexion' value='Very Fair' type='radio'> Very Fair</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbComplexion' value='Fair' type='radio'> Fair</label><br/>";
                        $body .= "<label  class='radio-inline'><input name='rdbComplexion' value='Wheatish' type='radio'> Wheatish</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbComplexion' value='Wheatish Brown' type='radio'> Wheatish Brown</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbComplexion' value='Dark' type='radio'> Dark</label>";
                        $body .= "</div>";            
                        $body .= "</div>";

                        $body .= "<div  class='form-group'>";
                        $body .= "<label class='col-md-4 control-label'>Physical Status:</label>";
                        $body .= "<div class='col-md-8'>";
                        $body .= "<label  class='radio-inline'><input name='rdbPhysicalStatus' value='Normal' type='radio'> Normal</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbPhysicalStatus' value='Physical Chalanged' type='radio'> Physical Chalanged</label>";
                        $body .= "</div>";            
                        $body .= "</div>";

                        $body .= "<div  class='form-group'>";
                        $body .= "<label class='col-md-4 control-label'>Drink Habits:</label>";
                        $body .= "<div class='col-md-8'>";
                        $body .= "<label  class='radio-inline'><input name='rdbdrinkHabits' value='No' type='radio'> No</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbdrinkHabits' value='Yes'type='radio'> Yes</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbdrinkHabits' value='Social' type='radio'> Social</label>";
                        $body .= "</div>";            
                        $body .= "</div>";

                        $body .= "<div  class='form-group'>";
                        $body .= "<label class='col-md-4 control-label'>Smoke Habits:</label>";
                        $body .= "<div class='col-md-8'>";
                        $body .= "<label  class='radio-inline'><input name='rdbsmokeHabits' value='No' type='radio'> No</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbsmokeHabits' value='Yes' type='radio'> Yes</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbsmokeHabits' value='Social' type='radio'> Social</label>";
                        $body .= "</div>";            
                        $body .= "</div>";

                        $body .= "<div  class='form-group'>";
                        $body .= "<label class='col-md-4 control-label'>Eating Habits:</label>";
                        $body .= "<div class='col-md-8'>";
                        $body .= "<label  class='radio-inline'><input name='rdbeatingHabits' value='Vegetarian' type='radio'> Vegetarian</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbeatingHabits' value='Non-Veg' type='radio'> Non-Veg</label>";
                        $body .= "<label  class='radio-inline'><input name='rdbeatingHabits' value='Eggetarian' type='radio'> Eggetarian</label>";
                        $body .= "</div>";
                        $body .= "</div>";

                        $body .= "<div  class='form-group'>";
                        $body .= "<label class='col-md-4 control-label'>Martial Status:</label>";
                        $body .= "<div class='col-md-8'>";
                        $body .= "<select name='ddlMStatus' id='ddlMStatus' class='form-control input-lg'>";
                        $body .= "<option value='Widow'>Widow</option>";
                        $body .= "<option value='Single'>Single</option>";
                        $body .= "<option value='Divorced'>Divorced</option>";
                        $body .= "<option value='Awaiting Divorce'>Awaiting Divorce</option>";
                        $body .= "</select>";
                        $body .= "</div>";
                        $body .= "</div>";

                        $body .= "<div  class='form-group'>";
                        $body .= "<label class='col-md-4 control-label'>Height(kg):</label>";
                        $body .= "<div class='col-md-8'>";
                        $body .= "<input type='text' id='txtHeight' name='txtHeight' class='form-control input-md input-lg' required='required' />";
                        $body .= "<div id='errHeight' style='color:red'></div>";
                        $body .= "</div>";            
                        $body .= "</div>";

                        $body .= "<div  class='form-group'>";
                        $body .= "<label class='col-md-4 control-label'>Weight(kg):</label>";
                        $body .= "<div class='col-md-8'>";
                        $body .= "<input type='text' id='txtWeight' name='txtWeight' class='form-control input-md input-lg' required='required' />";
                        $body .= "<div id='errWeight' style='color:red'></div>";
                        $body .= "</div>";            
                        $body .= "</div>";

                        $body .= "<div  class='form-group'>";
                        $body .= "<label class='col-md-4 control-label'>Mother Tongue:</label>";
                        $body .= "<div class='col-md-8'>";
                        $body .= "<input type='text' id='txtMotherTongue' name='txtMotherTongue' class='form-control input-md input-lg' required='required' />";
                        $body .= "<div id='errMotherT' style='color:red'></div>";
                        $body .= "</div>";
                        $body .= "</div>";

                        $body .= "<div  class='form-group'>";
                        $body .= "<label class='col-md-4 control-label'>Hair Color:</label>";
                        $body .= "<div class='col-md-8'>";
                        $body .= "<input type='text' id='txtHairColor' name='txtHairColor' class='form-control input-md input-lg' required='required' />";
                        $body .= "<div id='errHairColor' style='color:red'></div>";
                        $body .= "</div>";            
                        $body .= "</div>";

                       $body .= "<div  class='form-group'>";
                       $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
                       $body .= "<div class='col-md-8'>";
                       $body .= "<input type='submit' name='updBasicDet' id='updBasicDet' value='Update' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
                       $body .= "<a href='#' id='cancBasicDet' class='btn btn-success'>Cancel</a>";
                       $body .= "</div>";            
                       $body .= "</div>";
                    $body .= "</div>";
            }
      //=========================== USER FEW WORDS AND BASIC INFO SECTIONS [ENDS HERE]==================================

      //=========================== USER LOCATION SECTIONS [STARTS HERE]================================== 
        if(count($UserLocation)>0)
            {
                $countryName = $UserLocation[0]['countryName'];
                $state = $UserLocation[0]['state'];
                $city = $UserLocation[0]['city'];

                $countryId = $UserLocation[0]['countryId'];
                $stateId = $UserLocation[0]['stateId'];
                $cityId = $UserLocation[0]['cityId'];

                $citizen = $UserLocation[0]['citizen'];
                $residentStatus = $UserLocation[0]['residentStatus'];
            }
            else
            {      

                $countryId = $stateId = $cityId = 0;

                $countryName = $state = $city = $citizen = $residentStatus = "---";
            }

            $body .= "<div id='simpleDivLoc'>";
                $body .= "<div  class='form-group'>";
                $body .= "<div class='col-md-12'><hr /></div>";
                $body .= "<table style='width: 100%;'><tr><td><h3><strong>Location</strong></h3></td>";   
                $body .= "<td style='text-align: right;'>";        
                if($personalAcc){
                    //$body .= "<a href='profile.php?actEdit=locEdit'>Edit</a>";
                    $body .= "<a href='#' id='locEdit'>Edit</a>";
                } 
                $body .= "</td></tr></table>"; 
                $body .= "</div>";
                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Country:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblCountry' name='lblCountry' style='font-weight: normal;'>{$countryName}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Province:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblState' name='lblState' style='font-weight: normal;'>{$state}</label>";
                $body .= "</div>";
                $body .= "</div>";
                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>City:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblCity' name='lblCity' style='font-weight: normal;'>{$city}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Citizen:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblCitizen' name='lblCitizen' style='font-weight: normal;'>{$citizen}</label>";
                $body .= "</div>";
                $body .= "</div>";
                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Resident Status:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label style='font-weight: normal;' id='lblResident' name='lblResident'>{$residentStatus}</label>";
                $body .= "</div>";
                $body .= "</div>";   
            $body .= "</div>";                   
            if($personalAcc){
                   $body .= "<div id='editDivLoc'>";
                       $body .= "<div  class='form-group'>";
                       $body .= "<div class='col-md-12'><hr /></div>";
                       $body .= "<table style='width: 100%;'><tr><td><h3><strong>Location</strong></h3></td>";   
                       $body .= "<td style='text-align: right;'></td></tr></table>"; 
                       $body .= "</div>";
                       $body .= "<div  class='form-group'>";
                       $body .= "<label class='col-md-4 control-label'>Country:</label>"; 
                       $body .= "<div class='col-md-8'>";
                       $body .= "<input type='hidden' name='hdnCountryId' id='hdnCountryId' value='{$countryId}'/>";
                       $body .= "<select name='ddlCountry' id='ddlCountry' class='form-control input-lg' onchange='loadStates();'>";
                       $body .= "</select>";
                       $body .= "</div>";
                       $body .= "</div>";

                       $body .= "<div  class='form-group'>";
                       $body .= "<label class='col-md-4 control-label'>Province:</label>";
                       $body .= "<div class='col-md-8'>";            
                       $body .= "<input type='hidden' name='hdnStateId' id='hdnStateId' value='{$stateId}'/>";
                       $body .= "<select name='ddlStates' id='ddlStates' class='form-control input-lg' onchange='loadCities();'>";
                       $body .= "</select>";
                       $body .= "</div>";
                       $body .= "</div>";

                       $body .= "<div  class='form-group'>";
                       $body .= "<label class='col-md-4 control-label'>City:</label>";
                       $body .= "<div class='col-md-8'>";            
                       $body .= "<input type='hidden' name='hdnCityId' id='hdnCityId' value='{$cityId}'/>";
                       $body .= "<select name='ddlCities' id='ddlCities' class='form-control input-lg'>";
                       $body .= "</select>";
                       $body .= "</div>";
                       $body .= "</div>";

                       $body .= "<div  class='form-group'>";
                       $body .= "<label class='col-md-4 control-label'>Citizen:</label>";
                       $body .= "<div class='col-md-8'>";
                       $body .= "<input type='text' id='txtCitizen' name='txtCitizen' value='{$citizen}' class='form-control input-md input-lg' required='required' />";
                       $body .= "<div id='errCitizen' style='color:red'></div>";
                       $body .= "</div>";
                       $body .= "</div>";
                       $body .= "<div  class='form-group'>";
                       $body .= "<label class='col-md-4 control-label'>Resident Status:</label>";
                       $body .= "<div class='col-md-8'>";
                       $body .= "<input type='text' id='txtResident' name='txtResident' value='{$residentStatus}' class='form-control input-md input-lg' required='required' />";
                       $body .= "<div id='errResident' style='color:red'></div>";
                       $body .= "</div>";
                       $body .= "</div>";  
                       $body .= "<div  class='form-group'>";
                       $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
                       $body .= "<div class='col-md-8'>";
                       $body .= "<input type='submit' name='updLoc' id='updLoc' value='Update' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
                       $body .= "<a href='#' id='cancDivLoc' class='btn btn-success'>Cancel</a>";
                       $body .= "</div>";            
                       $body .= "</div>";
                   $body .= "</div>";            
            }
      //=========================== USER LOCATION SECTIONS [ENDS HERE]==================================

      //=========================== USER FAMILY DETAILS SECTIONS [STARTS HERE]==================================
            if(count($UserFDet)>0)
            {
                $livingWith = $UserFDet[0]['livingWith'];
                $familyType = $UserFDet[0]['familyType'];
                $familyValues = $UserFDet[0]['familyValues'];
                $familyStatus = $UserFDet[0]['familyStatus'];
                $noOfSisters = $UserFDet[0]['noOfSisters'];
                $noOfBrothers = $UserFDet[0]['noOfBrothers'];
                $marriedSisters = $UserFDet[0]['marriedSisters'];
                $marriedBrothers = $UserFDet[0]['marriedBrothers'];
                $fatherOccupation = $UserFDet[0]['fatherOccupation'];
                $motherOccupation = $UserFDet[0]['motherOccupation'];
            }
            else
            {      
                $livingWith = $familyType = $familyValues = $familyStatus = "---"; 
                $marriedSisters = $marriedBrothers = $fatherOccupation = $motherOccupation = "---";
                $noOfSisters = $noOfBrothers = "0";
            }

            $body .= "<div id='simpleDivFamDet'>";
                $body .= "<div  class='form-group'>";
                $body .= "<div class='col-md-12'><hr /></div>";
                $body .= "<table style='width: 100%;'><tr><td><h3><strong>Family Details</strong></h3></td>";    
                $body .= "<td style='text-align: right;'>";        
                if($personalAcc){
                    //$body .= "<a href='profile.php?actEdit=famDetEdit'>Edit</a>";
                    $body .= "<a href='#' id='famDetEdit'>Edit</a>";
                }
                $body .= "</td></tr></table>"; 
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Living With:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblLivingW' name='lblLivingW' style='font-weight: normal;'>{$livingWith}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Family Type:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblFType' name='lblFType' style='font-weight: normal;'>{$familyType}</label>";
                $body .= "</div>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Family Values:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblFValue' name='lblFValue' style='font-weight: normal;'>{$familyValues}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Family Status:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblFStat' name='lblFStat' style='font-weight: normal;'>{$familyStatus}</label>";
                $body .= "</div>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Brothers:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblNumBros' name='lblNumBros' style='font-weight: normal;'>{$noOfBrothers}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Sisters:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblNumSis' name='lblNumSis' style='font-weight: normal;'>{$noOfSisters}</label>";
                $body .= "</div>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Married Sisters:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblMSis' name='lblMSis' style='font-weight: normal;'>{$marriedSisters}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Married Brothers:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblMBros' name='lblMBros' style='font-weight: normal;'>{$marriedBrothers}</label>";
                $body .= "</div>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Father Occupation:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblFOcc' name='lblFOcc' style='font-weight: normal;'>{$fatherOccupation}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Mother Occupation:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblMOcc' name='lblMOcc' style='font-weight: normal;'>{$motherOccupation}</label>";
                $body .= "</div>";
                $body .= "</div>";
            $body .= "</div>";          
            if($personalAcc){
                $body .= "<div id='editDivFamDet'>";
                    $body .= "<div  class='form-group'>";
                    $body .= "<div class='col-md-12'><hr /></div>";
                    $body .= "<table style='width: 100%;'><tr><td><h3><strong>Family Details</strong></h3></td>";    
                    $body .= "<td style='text-align: right;'>";  
                    $body .= "</td></tr></table>"; 
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Living With:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<label  class='radio-inline'><input name='rdbLiv' value='Parents'";
                    $body .= " type='radio'> Parents</label>";
                    $body .= "<label  class='radio-inline'><input name='rdbLiv' value='Alone'";
                    $body .= " type='radio'> Alone</label>";
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Family Type:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<label  class='radio-inline'><input name='rdbFamType' value='Joint Family'";
                    $body .= " type='radio'> Joint Family</label>";
                    $body .= "<label  class='radio-inline'><input name='rdbFamType' value='Nuclear'";
                    $body .= " type='radio'> Nuclear</label>";
                    $body .= "<label  class='radio-inline'><input name='rdbFamType' value='Others'";
                    $body .= " type='radio'> Others</label>";
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Family Values:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<label  class='radio-inline'><input name='rdbFamVal' value='Traditional'";
                    $body .= " type='radio'> Traditional</label>";
                    $body .= "<label  class='radio-inline'><input name='rdbFamVal' value='Moderate'";
                    $body .= " type='radio'> Moderate</label>";
                    $body .= "<label  class='radio-inline'><input name='rdbFamVal' value='Liberal'";
                    $body .= " type='radio'> Liberal</label>";
                    $body .= "<label  class='radio-inline'><input name='rdbFamVal' value='Orthodox'";
                    $body .= " type='radio'> Orthodox</label>";            
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Family Status:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<label  class='radio-inline'><input name='rdbFamStat' value='Middle Class'";
                    $body .= " type='radio'> Middle Class</label>"; 
                    $body .= "<label  class='radio-inline'><input name='rdbFamStat' value='Upper Middle Class'";
                    $body .= " type='radio'> Upper Middle Class</label>";  
                    $body .= "<label  class='radio-inline'><input name='rdbFamStat' value='Rich'";
                    $body .= " type='radio'> Rich</label>"; 
                    $body .= "<label  class='radio-inline'><input name='rdbFamStat' value='Affluent'";
                    $body .= " type='radio'> Affluent</label>";             
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Brothers:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='text' id='txtNumBro' name='txtNumBro' value='{$noOfBrothers}' class='form-control input-md input-lg' required='required' />";
                    $body .= "<div id='errNBro' style='color:red'></div>";
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Sisters:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='text' id='txtNumSis' name='txtNumSis' value='{$noOfSisters}' class='form-control input-md input-lg' required='required' />";
                    $body .= "<div id='errNSis' style='color:red'></div>";
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Married Sisters:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='text' id='txtMrdSis' name='txtMrdSis' value='{$marriedSisters}' class='form-control input-md input-lg' required='required' />";
                    $body .= "<div id='errMSis' style='color:red'></div>";
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Married Brothers:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='text' id='txtMrdBro' name='txtMrdBro' value='{$marriedBrothers}' class='form-control input-md input-lg' required='required' />";
                    $body .= "<div id='errMBro' style='color:red'></div>";
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Father Occupation:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='text' id='txtFatherOcc' name='txtFatherOcc' value='{$fatherOccupation}' class='form-control input-md input-lg' required='required' />";
                    $body .= "<div id='errFOcc' style='color:red'></div>";
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Mother Occupation:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='text' id='txtMotherOcc' name='txtMotherOcc' value='{$motherOccupation}' class='form-control input-md input-lg' required='required' />";
                    $body .= "<div id='errMOcc' style='color:red'></div>";
                    $body .= "</div>";
                    $body .= "</div>";
                    
                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='submit' name='updFamDet' id='updFamDet' value='Update' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
                    $body .= "<a href='#' id='cancFamDet' class='btn btn-success'>Cancel</a>";
                    $body .= "</div>";            
                    $body .= "</div>";
                $body .= "</div>";
            }
      //=========================== USER FAMILY DETAILS SECTIONS [ENDS HERE]==================================
      //
      //=========================== USER PROFESSIONAL SECTIONS [STARTS HERE]==================================
            if(count($UserProf)>0)
            {
                $education = $UserProf[0]['education'];
                $college = $UserProf[0]['college'];
                $additionalDegree = $UserProf[0]['additionalDegree'];
                $occupation = $UserProf[0]['occupation'];
                $employedIn = $UserProf[0]['employedIn'];
                $annualIncome = $UserProf[0]['annualIncome'];
            }
            else
            {      
                $education = $college = $additionalDegree = $occupation = $employedIn = $annualIncome = "---";
            }

            $body .= "<div id='simpleDivProfDet'>";
                $body .= "<div  class='form-group'>";
                $body .= "<div class='col-md-12'><hr /></div>";
                $body .= "<table style='width: 100%;'><tr><td><h3><strong>Professional Details</strong></h3></td>";    
                $body .= "<td style='text-align: right;'>";        
                if($personalAcc){
    //                $body .= "<a href='profile.php?actEdit=ProfDet'>Edit</a>";
                    $body .= "<a href='#' id='profEdit'>Edit</a>";
                }
                $body .= "</td></tr></table>"; 
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Education:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblEdu' name='lblEdu' style='font-weight: normal;'>{$education}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>College:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblColg' name='lblColg' style='font-weight: normal;'>{$college}</label>";
                $body .= "</div>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Additional Degree:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblADeg' name='lblADeg' style='font-weight: normal;'>{$additionalDegree}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Occupation:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblOccup' name='lblOccup' style='font-weight: normal;'>{$occupation}</label>";
                $body .= "</div>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Employed In:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblEmpIn' name='lblEmpIn' style='font-weight: normal;'>{$employedIn}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Annual Income:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblAIncome' name='lblAIncome' style='font-weight: normal;'>{$annualIncome}</label>";
                $body .= "</div>";
                $body .= "</div>";
            $body .= "</div>";          
            if($personalAcc){
                $body .= "<div id='editDivProfDet'>";
                    $body .= "<div  class='form-group'>";
                    $body .= "<div class='col-md-12'><hr /></div>";
                    $body .= "<table style='width: 100%;'><tr><td><h3><strong>Professional Details</strong></h3></td>";    
                    $body .= "<td style='text-align: right;'>";  
                    $body .= "</td></tr></table>"; 
                    $body .= "</div>";
                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Education:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='text' id='txtEdu' name='txtEdu' value='{$education}' class='form-control input-md input-lg' required='required' />";
                        $body .= "<div id='errEdu' style='color:red'></div>";
                    $body .= "</div>";
                    $body .= "</div>";
                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>College:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='text' id='txtClg' name='txtClg' value='{$college}' class='form-control input-md input-lg' required='required' />";
                        $body .= "<div id='errColg' style='color:red'></div>";
                    $body .= "</div>";
                    $body .= "</div>";
                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Additional Degree:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='text' id='txtADeg' name='txtADeg' value='{$additionalDegree}' class='form-control input-md input-lg' required='required' />";
                        $body .= "<div id='errAdeg' style='color:red'></div>";
                    $body .= "</div>";
                    $body .= "</div>";
                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Occupation:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='text' id='txtOccp' name='txtOccp' value='{$occupation}' class='form-control input-md input-lg' required='required' />";
                        $body .= "<div id='errOcc' style='color:red'></div>";
                    $body .= "</div>";
                    $body .= "</div>";
                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Employed In:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<label  class='radio-inline'><input name='rdbEmpIn' value='Private'";
                    $body .= " type='radio'> Private</label>";
                    $body .= "<label  class='radio-inline'><input name='rdbEmpIn' value='Government'";
                    $body .= " type='radio'> Government</label>";
                    $body .= "<label  class='radio-inline'><input name='rdbEmpIn' value='Others'";
                    $body .= " type='radio'> Others</label>";
                    $body .= "</div>";
                    $body .= "</div>";
                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Annual Income:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='text' id='txtAInc' name='txtAInc' value='{$annualIncome}' class='form-control input-md input-lg' required='required' />";
                        $body .= "<div id='errAnnInc' style='color:red'></div>";
                    $body .= "</div>";
                    $body .= "</div>";
                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='submit' name='updProfDet' id='updProfDet' value='Update' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
                    $body .= "<a href='#' id='cancProfDet' class='btn btn-success'>Cancel</a>";
                    $body .= "</div>";            
                    $body .= "</div>";
                $body .= "</div>";
            }
      //=========================== USER PROFESSIONAL DETAILS SECTIONS [ENDS HERE]==================================

      //
      //=========================== USER HOBBIES SECTIONS [STARTS HERE]==================================
            if(count($UserHobbies)>0)
            {
                $hobbies = $UserHobbies[0]['hobbies'];
                $interests = $UserHobbies[0]['interests'];
                $dressStyle = $UserHobbies[0]['DressStyle'];
                $spokenLanguage = $UserHobbies[0]['spokenLanguage'];
            }
            else
            {      
                $hobbies = $interests = $dressStyle = $spokenLanguage = "---";
            }
            $body .= "<div id='simpleDivHobbies'>";
                $body .= "<div  class='form-group'>";
                $body .= "<div class='col-md-12'><hr /></div>";
                $body .= "<table style='width: 100%;'><tr><td><h3><strong>Hobbies and Interests</strong></h3></td>";      
                $body .= "<td style='text-align: right;'>";        
                if($personalAcc){
    //                $body .= "<a href='profile.php?actEdit=hopEdit'>Edit</a>";
                    $body .= "<a href='#' id='hobbiesEdit'>Edit</a>";
                }
                $body .= "</td></tr></table>"; 
                $body .= "</div>";
                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Hobbies:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblHobbies' name='lblHobbies' style='font-weight: normal;'>{$hobbies}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Interests:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblInts' name='lblInts' style='font-weight: normal;'>{$interests}</label>";
                $body .= "</div>";
                $body .= "</div>";
                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-3 control-label'>Dress Style:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblDStyles' name='lblDStyles' style='font-weight: normal;'>{$dressStyle}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-3 control-label'>Spoken Language:</label>";
                $body .= "<div class='col-md-3'>";
                $body .= "<label id='lblSLanguages' name='lblSLanguages' style='font-weight: normal;'>{$spokenLanguage}</label>";
                $body .=  "</div>";
                $body .= "</div>";
            $body .= "</div>";          
            if($personalAcc){
                $body .= "<div id='editDivHobbies'>";
                    $body .= "<div  class='form-group'>";
                    $body .= "<div class='col-md-12'><hr /></div>";
                    $body .= "<table style='width: 100%;'><tr><td><h3><strong>Hobbies and Interests</strong></h3></td>";      
                    $body .= "<td style='text-align: right;'>";
                    $body .= "</td></tr></table>"; 
                    $body .= "</div>";
                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Hobbies:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<label class='checkbox-inline' for='chkHobbies'>";
                      $body .= "<input name='chkHobbies' id='chkHobbies' value='Acting' type='checkbox'>";
                      $body .= "Acting";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkHobbies'>";
                      $body .= "<input name='chkHobbies' id='chkHobbies' value='Pets' type='checkbox'>";
                      $body .= "Pets";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkHobbies'>";
                      $body .= "<input name='chkHobbies' id='chkHobbies' value='Collection' type='checkbox'>";
                      $body .= "Collection";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkHobbies'>";
                      $body .= "<input name='chkHobbies' id='chkHobbies' value='Dancing' type='checkbox'>";
                      $body .= "Dancing";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkHobbies'>";
                      $body .= "<input name='chkHobbies' id='chkHobbies' value='Fishing' type='checkbox'>";
                      $body .= "Fishing";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkHobbies'>";
                      $body .= "<input name='chkHobbies' id='chkHobbies' value='Cooking' type='checkbox'>";
                      $body .= "Cooking";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkHobbies'>";
                      $body .= "<input name='chkHobbies' id='chkHobbies' value='Photography' type='checkbox'>";
                      $body .= "Photography";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkHobbies'>";
                      $body .= "<input name='chkHobbies' id='chkHobbies' value='Nature' type='checkbox'>";
                      $body .= "Nature";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkHobbies'>";
                      $body .= "<input name='chkHobbies' id='chkHobbies' value='Painting' type='checkbox'>";
                      $body .= "Painting";
                    $body .= "</label>";
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Interests:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<label class='checkbox-inline' for='chkInterests'>";
                      $body .= "<input name='chkInterests' id='chkInterests' value='Palmistry' type='checkbox'>";
                      $body .= "Palmistry";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkInterests'>";
                      $body .= "<input name='chkInterests' id='chkInterests' value='Graphology' type='checkbox'>";
                      $body .= "Graphology";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkInterests'>";
                      $body .= "<input name='chkInterests' id='chkInterests' value='Numerology' type='checkbox'>";
                      $body .= "Numerology";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkInterests'>";
                      $body .= "<input name='chkInterests' id='chkInterests' value='Collectibles' type='checkbox'>";
                      $body .= "Collectibles";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkInterests'>";
                      $body .= "<input name='chkInterests' id='chkInterests' value='Astronomy' type='checkbox'>";
                      $body .= "Astronomy";
                    $body .= "</label>";
                    $body .= "<label class='checkbox-inline' for='chkInterests'>";
                      $body .= "<input name='chkInterests' id='chkInterests' value='Handicraft' type='checkbox'>";
                      $body .= "Handicraft";
                    $body .= "</label>";
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Dress Style:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<label class='checkbox-inline' for='chkDressStyle'>";
                      $body .= "<input name='chkDressStyle' id='chkDressStyle' value='Casual Wear' type='checkbox'>";
                      $body .= "Casual Wear";
                    $body .= "</label>"; 
                    $body .= "<label class='checkbox-inline' for='chkDressStyle'>";
                      $body .= "<input name='chkDressStyle' id='chkDressStyle' value='Designer Wear' type='checkbox'>";
                      $body .= "Designer Wear";
                    $body .= "</label>"; 
                    $body .= "<label class='checkbox-inline' for='chkDressStyle'>";
                      $body .= "<input name='chkDressStyle' id='chkDressStyle' value='Indian Wear' type='checkbox'>";
                      $body .= "Indian Wear";
                    $body .= "</label>"; 
                    $body .= "<label class='checkbox-inline' for='chkDressStyle'>";
                      $body .= "<input name='chkDressStyle' id='chkDressStyle' value='Western Wear' type='checkbox'>";
                      $body .= "Western Wear";
                    $body .= "</label>";
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Spoken Language:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<select name='spokenLangs[]' id='spokenLangs' multiple='multiple' size='10'>";
                    $body .= "<option value='Arabic'>Arabic</option>";
                    $body .= "<option value='English'>English</option>";
                    $body .= "<option value='French'>French</option>";
                    $body .= "<option value='Punjabi'>Punjabi</option>";
                    $body .= "<option value='Russian'>Russian</option>";
                    $body .= "<option value='Spanish'>Spanish</option>";
                    $body .= "</select>";
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='submit' name='updLang' id='updHobbies' value='Update' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
                    $body .= "<a href='#' id='cancHobbies' class='btn btn-success'>Cancel</a>";
                    $body .= "</div>";            
                    $body .= "</div>";
                $body .= "</div>";     
            }
      //=========================== USER HOBBIES DETAILS SECTIONS [ENDS HERE]==================================


      //=========================== USER PARTNER PREFERENCES SECTIONS [STARTS HERE]==================================
            if(count($UserPPref)>0)
            {
                $ageFrom = $UserPPref[0]['ageFrom'];
                $ageTo = $UserPPref[0]['ageTo'];
                $countries = $UserPPref[0]['countries'];
            }
            else
            {      
                $ageFrom = $ageTo = $countries = "---";
            }
            $body .= "<div id='simpleDivPartPref'>";
                $body .= "<div  class='form-group'>";
                $body .= "<div class='col-md-12'><hr /></div>";
                $body .= "<table style='width: 100%;'><tr><td><h3><strong>Partner Preferences</strong></h3></td>";      
                $body .= "<td style='text-align: right;'>";        
                if($personalAcc){
    //                $body .= "<a href='profile.php?actEdit=partEdit'>Edit</a>";
                    $body .= "<a href='#' id='partPrefEdit'>Edit</a>";
                }
                $body .= "</td></tr></table>"; 
                $body .= "</div>";
                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-4 control-label'>Age From:</label>";
                $body .= "<div class='col-md-2'>";
                $body .= "<label  id='lblFromAge' style='font-weight: normal;'>{$ageFrom}</label>";
                $body .= "</div>";
                $body .= "<label class='col-md-4 control-label'>Age To:</label>";
                $body .= "<div class='col-md-2'>";
                $body .= "<label  id='lblToAge' style='font-weight: normal;'>{$ageTo}</label>";
                $body .= "</div>";
                $body .= "</div>";

                $body .= "<div  class='form-group'>";
                $body .= "<label class='col-md-4 control-label'>Country:</label>";
                $body .= "<div class='col-md-8'>";
                $body .= "<label id='lblCntry' style='font-weight: normal;'>{$countries}</label>";
                $body .= "</div>";
                $body .= "</div>";
            $body .= "</div>";          
            if($personalAcc){
                $body .= "<div id='editDivPartPref'>";
                    $body .= "<div  class='form-group'>";
                    $body .= "<div class='col-md-12'><hr /></div>";
                    $body .= "<table style='width: 100%;'><tr><td><h3><strong>Partner Preferences</strong></h3></td>";      
                    $body .= "<td style='text-align: right;'>";  
                    $body .= "</td></tr></table>"; 
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Age From:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<select id='ddlFromAge' name='ddlFromAge' class='form-control input-lg'>";
                    $body .= "</select>";
                    $body .=  "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Age To:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<select id='ddlToAge' name='ddlToAge' class='form-control input-lg'>";
                    $body .= "</select>";
                    $body .=  "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>Country:</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<select name='lstCntry[]' id='lstCntry'  multiple='multiple' size='10'>";
                    $body .= "</select>";
                    $body .= "</div>";
                    $body .= "</div>";

                    $body .= "<div  class='form-group'>";
                    $body .= "<label class='col-md-4 control-label'>&nbsp;</label>";
                    $body .= "<div class='col-md-8'>";
                    $body .= "<input type='submit' name='updPartPref' id='updPartPref' value='Update' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
                    $body .= "<a href='#' id='cancPartPref' class='btn btn-success'>Cancel</a>";
                    $body .= "</div>";            
                    $body .= "</div>";
                $body .= "</div>";     
            }
      //=========================== USER PROFESSIONAL DETAILS SECTIONS [ENDS HERE]==================================
            $body .= "</form>";
            
        }
        else
        {            
        $body = "<form class='form-horizontal' method='post'>";
        $body .= "<label style='color:Red;' name='lblMsg' id='lblMsg'>The profile you are looking for doesn't exists or it has been deleted.</label><br/>";
        $body .= "</form>";        
        }

        
 $objPage->displayPage($body);
?>