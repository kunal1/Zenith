<?php
/**
 * Description of userInfoDB
 *
 * @author Jagsir Singh
 */
class userInfoDB{
    
    public static function getUserRole($userId)
    { 
        $conn = Database::getDB(); 
        $sql = 'CALL spGetUserRole(:UsersId)';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }
        
    public static function getUserNameAddress($userId){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserNameAddress(:UsersId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
//        $stmt->bindParam(1, $second_name, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function getUserDetailsById($searchId, $userId){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserDetailsById(:UsersId, :SearchId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->bindParam('SearchId', $searchId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function getUserFamilyDetails($userId){         
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserFamilyDetails(:UsersId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function getUserHobbies($userId){         
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserHobbies(:UsersId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
//        $stmt->bindParam(1, $second_name, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function getUserLocation($userId){         
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserLocation(:UsersId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
//        $stmt->bindParam(1, $second_name, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function getUserPartnerPref($userId){         
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserPartnerPref(:UsersId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
//        $stmt->bindParam(1, $second_name, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function getUserProfession($userId){         
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserProfession(:UsersId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
//        $stmt->bindParam(1, $second_name, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }   
    
    public  static function updateUserBasicInfo($userId, $bodyType, $complexion, $physicalStatus, $height, $weight
            , $motherTounge, $martialStatus, $drinkHabits, $smokeHabits, $eatingHabits, $hairColor){
        $conn = Database::getDB(); 
        $sql = "CALL spUpdateUserBasicInfo(:UsersId, :bodyTypes, :complexions, :physicalStatuss, :heights"
                . ", :weights, :motherTounges, :martialStatuss, :drinkHabitss, :smokeHabitss, :eatingHabitss, :hairColors)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->bindParam('bodyTypes', $bodyType, PDO::PARAM_STR, 50);
        $stmt->bindParam('complexions', $complexion, PDO::PARAM_STR, 50);
        $stmt->bindParam('physicalStatuss', $physicalStatus, PDO::PARAM_STR, 50);
        $stmt->bindValue('heights', $height);
        $stmt->bindValue('weights', $weight);
        $stmt->bindParam('motherTounges', $motherTounge, PDO::PARAM_STR, 50);
        $stmt->bindParam('martialStatuss', $martialStatus, PDO::PARAM_STR, 50);
        $stmt->bindParam('drinkHabitss', $drinkHabits, PDO::PARAM_STR, 50);
        $stmt->bindParam('smokeHabitss', $smokeHabits, PDO::PARAM_STR, 50);
        $stmt->bindParam('eatingHabitss', $eatingHabits, PDO::PARAM_STR, 50);
        $stmt->bindParam('hairColors', $hairColor, PDO::PARAM_STR, 50);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        return $row_count;
    }   
    
    public static function updateUserLocation($userId, $country, $state, $city, $citizen, $residentStatus){
        $conn = Database::getDB(); 
        $sql = "CALL spUpdateUserLocation(:UsersId, :country, :state, :city, :citizenship, :residency)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->bindParam('country', $country, PDO::PARAM_INT, 11);
        $stmt->bindParam('state', $state, PDO::PARAM_INT, 11);
        $stmt->bindParam('city', $city, PDO::PARAM_INT, 11);
        $stmt->bindParam('citizenship', $citizen, PDO::PARAM_STR, 50);
        $stmt->bindParam('residency', $residentStatus, PDO::PARAM_STR, 50);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        return $row_count;
    }
    
    public static function updateFamilyDetails($userId, $livingWith, $familyType, $familyValues, $familyStatus, $noOfBrothers, $noOfSisters, $marriedBros, $marriedSis, $fatherOcc, $motherOcc){
        $conn = Database::getDB(); 
        $sql = "CALL spUpdateFamilyDetails(:UsersId, :livingWiths, :fType, :fValues, :fStatus, :numBros, :numSis, :marriedSister, :marriedBrother, :fatherOccu, :motherOccu)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->bindParam('livingWiths', $livingWith, PDO::PARAM_STR, 45);
        $stmt->bindParam('fType', $familyType, PDO::PARAM_STR, 45);
        $stmt->bindParam('fValues', $familyValues, PDO::PARAM_STR, 45);
        $stmt->bindParam('fStatus', $familyStatus, PDO::PARAM_STR, 45);
        $stmt->bindParam('numBros', $noOfBrothers, PDO::PARAM_INT, 11);
        $stmt->bindParam('numSis', $noOfSisters, PDO::PARAM_INT, 11);
        $stmt->bindParam('marriedSister', $marriedBros, PDO::PARAM_INT, 11);
        $stmt->bindParam('marriedBrother', $marriedSis, PDO::PARAM_INT, 11);
        $stmt->bindParam('fatherOccu', $fatherOcc, PDO::PARAM_STR, 45);
        $stmt->bindParam('motherOccu', $motherOcc, PDO::PARAM_STR, 45);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        return $row_count;
    }
        
    public static function updateProfessionalDetails($userId, $education, $college, $addDegree, $occupation, $employedIn, $annualInc){
        $conn = Database::getDB(); 
        $sql = "CALL spUserProfession(:UsersId, :educations, :colleges, :additionalDeg, :occu, :employed, :annual)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->bindParam('educations', $education, PDO::PARAM_STR, 200);
        $stmt->bindParam('colleges', $college, PDO::PARAM_STR, 50);
        $stmt->bindParam('additionalDeg', $addDegree, PDO::PARAM_STR, 50);
        $stmt->bindParam('occu', $occupation, PDO::PARAM_STR, 50);
        $stmt->bindParam('employed', $employedIn, PDO::PARAM_STR, 50);
        $stmt->bindParam('annual', $annualInc, PDO::PARAM_STR, 50);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        return $row_count;
    }
        
    public static function updateUserHobbies($userId, $hobs, $ints, $dS, $langs){
        $conn = Database::getDB(); 
        $sql = "CALL spUpdateUserHobbies(:UsersId, :hobby, :interest, :dressStyles, :languages)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->bindParam('hobby', $hobs, PDO::PARAM_STR, 500);
        $stmt->bindParam('interest', $ints, PDO::PARAM_STR, 500);
        $stmt->bindParam('dressStyles', $dS, PDO::PARAM_STR, 200);
        $stmt->bindParam('languages', $langs, PDO::PARAM_STR, 200);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        return $row_count;
    }
        
    public static function updateUserPartnerPrefs($userId, $fromAge, $toAge, $contrs){
        $conn = Database::getDB(); 
        $sql = "CALL spUpdatePartnerPref(:UsersId, :fromAge, :toAge, :countrys)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->bindParam('fromAge', $fromAge, PDO::PARAM_INT, 11);
        $stmt->bindParam('toAge', $toAge, PDO::PARAM_INT, 11);
        $stmt->bindParam('countrys', $contrs, PDO::PARAM_STR, 100);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        return $row_count;
    }
    
    public static function deleteUserAccount($userId){
        $conn = Database::getDB(); 
        $sql = "CALL spDelUserAccount(:UsersId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        return $row_count;
    }
    
}
?>
