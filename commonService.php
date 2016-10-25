<?php
require_once 'Database.php';
require_once 'commonDB.php';
require_once 'userInfoDB.php';

extract($_REQUEST);

$response;
$result="";
switch ($data)
{
    case 'getContactDetails':
	$response = commonDB::getContactDetails($uid, $contId);
        $result = array();   
        foreach ($response as $cont):
            $set = array("email" => $cont['email'],"phone"=>$cont['phone']);         
            $result[]=$set;
        endforeach;
        break;
    case 'getCountries':
	$response = commonDB::getCountries();
        $result = array();   
        foreach ($response as $cnt):
            $set = array("countryId" => $cnt['countryId'],"countryName"=>$cnt['countryName']);         
            $result[]=$set;
        endforeach;
        break;
    case 'getStates':
	$response = commonDB::getStates($cntryId);
        $result = array();   
        foreach ($response as $st):
            $set = array("stateId" => $st['stateId'],"state"=>$st['state']);         
            $result[]=$set;
        endforeach;
        break;
    case 'getCities':
	$response = commonDB::getCities($stId);
        $result = array();   
        foreach ($response as $ct):
            $set = array("cityId" => $ct['cityId'],"city"=>$ct['city']);         
            $result[]=$set;
        endforeach;
        break;
    case 'updateLoc':
      commonDB::chectStrings($result, $citiz, 'citizen');
      commonDB::chectStrings($result, $res, 'resident');
            
        if($result == ""){
            $response = userInfoDB::updateUserLocation($uid, $cntryId, $sttId, $ctyid, $citiz, $res);
            if($response)
            {
                $result = true;
            }
            else 
                {
                    $result = false;
                }
        }
        break;
    case 'updateFamDet':
        commonDB::chectNumbers($result, $nBros, 'nBro');
        commonDB::chectNumbers($result, $nSis, 'nSis');
        commonDB::chectNumbers($result, $marriedBros, 'mBro');
        commonDB::chectNumbers($result, $marriedSis, 'mSis');
        commonDB::chectStrings($result, $fatherOcc, 'fatherOcc');
        commonDB::chectStrings($result, $motherOcc, 'motherOcc');
            
        if($result == ""){
            $response = userInfoDB::updateFamilyDetails($uid, $liveWith, $fType, $fVal, $fState, $nBros, $nSis, $marriedBros, $marriedSis, $fatherOcc, $motherOcc);
            if($response)
            {
                $result = true;
            }
            else 
                {
                    $result = false;
                }
        }
        break;
    case 'updateProfDet':
        commonDB::chectStrings($result, $educ, 'educ');
        commonDB::chectStrings($result, $colg, 'colg');
        commonDB::chectStrings($result, $adegree, 'adeg');
        commonDB::chectStrings($result, $occup, 'occu');
        commonDB::chectDecimal($result, $anninc, 'anninc');
        
        if($result == ""){
            $response = userInfoDB::updateProfessionalDetails($uid, $educ, $colg, $adegree, $occup, $empdin, $anninc);
            if($response)
            {
                $result = true;
            }
            else 
                {
                    $result = false;
                }
        }
        break;
    case 'updateHobbies':
        $response = userInfoDB::updateUserHobbies($uid, $hobs, $ints, $dS, $langs);
        if($response)
        {
            $result = true;
        }
        else 
            {
                $result = false;
            }
        break;
    case 'updatePartnerPref':
        $response = userInfoDB::updateUserPartnerPrefs($uid, $fromAge, $toAge, $contrs);
        if($response)
        {
            $result = true;
        }
        else 
            {
                $result = false;
            }
        break;
    case 'updateBasicDet':
             
      commonDB::chectStrings($result, $MotherT, 'motherT');
      commonDB::chectStrings($result, $HairC, 'hairC');
      commonDB::chectDecimal($result, $Height, 'Height');
      commonDB::chectDecimal($result, $Weight, 'Weight');
            
        if($result == ""){
            $response = userInfoDB::updateUserBasicInfo($uid, $BodyT, $Complx, $PhysicalSt, $Height, $Weight, $MotherT, $MartialS, $DrinkH, $SmokeH, $EHabit, $HairC);
            if($response)
            {
                $result = true;
            }
            else 
                {
                    $result = false;
                }
        }
        break;
    case 'delAccount':
        $result = userInfoDB::deleteUserAccount($uid);
        break;
    default:
        $result = "fail";            
}
echo json_encode($result);
?>