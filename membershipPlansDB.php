
<?php
/**
 * Description of membershipPlansDB
 *
 * @author Jagsir Singh
 */
include_once 'Database.php';

class membershipPlansDB {
    
    public function getMembershipPlans(){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetMembershipPlans()";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    
    public static function updateMembership($membershipId, $membership, $daysAllowed, $contactsAllowed, $price, $comments){
        $conn = Database::getDB(); 
        $sql = "CALL spUpdateMembershipPlan(:memId, :memTitle, :days, :contacts, :totalPrice, :cmnts)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('memId', $membershipId, PDO::PARAM_INT, 11);
        $stmt->bindParam('memTitle', $membership, PDO::PARAM_STR, 50);
        $stmt->bindParam('days', $daysAllowed, PDO::PARAM_INT, 11);
        $stmt->bindParam('contacts', $contactsAllowed, PDO::PARAM_INT, 11);
        $stmt->bindValue('totalPrice', $price);
        $stmt->bindParam('cmnts', $comments, PDO::PARAM_STR, 500);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        $conn = null;
        return $row_count;
    }
    
    public static function saveMembership($membership, $daysAllowed, $contactsAllowed, $price, $comments){
        $conn = Database::getDB(); 
        $sql = "INSERT INTO tbl_memberships(membership, daysAllowed, contactsAllowed, price, comments)"
                . "VALUES(:memTitle, :days, :contacts, :totalPrice, :cmnts)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('memTitle', $membership, PDO::PARAM_STR, 50);
        $stmt->bindParam('days', $daysAllowed, PDO::PARAM_INT, 11);
        $stmt->bindParam('contacts', $contactsAllowed, PDO::PARAM_INT, 11);
        $stmt->bindValue('totalPrice', $price);
        $stmt->bindParam('cmnts', $comments, PDO::PARAM_STR, 500);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        $lastMemId = $conn->lastInsertId();
        $conn = null;
        return $lastMemId;
    }
    
    public function getUserMembershipDetails($userId){  
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserMembershipDetails(:UsersId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    
    public function getMembershipPlanDetails($planId){
        $conn = Database::getDB(); 
        $sql = "CALL spGetMembershipPlanDetails(:PlanId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('PlanId', $planId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    
    public static function deleteMembershipPlan($planId){   
        $conn = Database::getDB();      
        $sql = "CALL spDeleteMembershipPlan(:planId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('planId', $planId, PDO::PARAM_INT, 11);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        $conn = null;
        return $row_count;
    }
    
    public function addUserToMembership($userId, $planId){ 
        $conn = Database::getDB();      
        $sql = "CALL spAddUserToMembership(:UsersId, :memId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->bindParam('memId', $planId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $stmt->closeCursor();
        $conn = null;
    }
}

?>
