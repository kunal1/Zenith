<?php
require_once 'Database.php';
class commonDB {
    public static function getCountries(){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetCountries()";
        $stmt = $conn->prepare($sql);
        //$stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    public static function getStates($countryId){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetStates(:Country)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('Country', $countryId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    public static function getCities($stateId){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetCities(:state)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('state', $stateId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    public static function getContactDetails($uid, $cntId){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetContactDetails(:UsersId, :contactsId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $uid, PDO::PARAM_INT, 11);
        $stmt->bindParam('contactsId', $cntId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    public static function  getReligions(){
        $conn=  Database::getDB();
        $sql="CALL spGetReligion";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $rows=$stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    public static function getSearchResult($gender,$ageFrom,$ageTo,$heightFrom,$heightTo,$martialStatus,$religion,$countryName){
        $conn=  Database::getDB();
        $sql="CALL getSearchResult(:gender,:ageFrom,:ageTo,:heightFrom,:heightTo,:martialStatus,:religion,:countryName)";
        $stmt=$conn->prepare($sql);
        $stmt->bindParam('gender',$gender,  PDO::PARAM_STR,1);
                $stmt->bindParam('ageFrom',$ageFrom,  PDO::PARAM_INT,11);
$stmt->bindParam('ageTo',$ageTo,  PDO::PARAM_INT,11);
$stmt->bindParam('heightFrom',$heightFrom,  PDO::PARAM_INT);
$stmt->bindParam('heightTo',$heightTo,  PDO::PARAM_INT);
$stmt->bindParam(':martialStatus',$martialStatus,  PDO::PARAM_STR,50);
$stmt->bindParam(':religion',$religion,  PDO::PARAM_STR,50);
$stmt->bindParam(':countryName',$countryName,  PDO::PARAM_STR,50);

        $stmt->execute();
        $rows=$stmt->fetchAll();
        $conn = null;
        return $rows;;
    }
    public static function chectStrings(&$result, $value,$errName){
        if(preg_match('/^[a-z][a-z ]*$/i',$value)==0)
        {
            if($result != ""){
                $result .= ", " . $errName;
            }
            else{
                $result .= $errName;
            }
        }
    }
    
    public static function chectDecimal(&$result, $value,$errName){
        if(preg_match('/^[0-9]+(?:\.[0-9]{1,2})?$/im',$value)==0)
        {
            if($result != ""){
                $result .= ", " . $errName;
            }
            else{
                $result .= $errName;
            }
        }
    }
    
    public static function chectNumbers(&$result, $value,$errName){
        if(preg_match('/^\d+$/',$value)==0)
        {
            if($result != ""){
                $result .= ", " . $errName;
            }
            else{
                $result .= $errName;
            }
        }
    }
    
    function valid_email ($email) {
    $parts = explode("@", $email);
    if (count($parts) != 2 ) return false;
    if (strlen($parts[0]) > 64) return false;
    if (strlen($parts[1]) > 255) return false;

    $atom = '[[:alnum:]_!#$%&\'*+\/=?^`{|}~-]+';
    $dotatom = '(\.' . $atom . ')*';
    $address = '(^' . $atom . $dotatom . '$)';
    $char = '([^\\\\"])';
    $esc  = '(\\\\[\\\\"])';
    $text = '(' . $char . '|' . $esc . ')+';
    $quoted = '(^"' . $text . '"$)';
    $local_part = '/' . $address . '|' . $quoted . '/';
    $local_match = preg_match($local_part, $parts[0]);
    if ($local_match === false 
        || $local_match != 1) return false;
        $hostname = '([[:alnum:]]([-[:alnum:]]{0,62}[[:alnum:]])?)';
    $hostnames = '(' . $hostname . 
                 '(\.' . $hostname . ')*)';
    $top = '\.[[:alnum:]]{2,6}';
    $domain_part = '/^' . $hostnames . $top . '$/';
    $domain_match = preg_match($domain_part, $parts[1]);
    if ($domain_match === false 
        || $domain_match != 1) return false;

    return true;

    }
    
    
    }
