<?php

include_once 'Database.php';

class specialOffersDB {
    
    public function getSpecialOffers()
            {    
        $conn = Database::getDB(); 
        $sql = "CALL spGetSpecialOffers()";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public static function updateOffers($specialId, $special, $daysAllowed, $price){
        $conn = Database::getDB(); 
        $sql = "CALL spUpdateSpecialOffers(:speId, :speTitle, :days, :totalPrice)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('speId', $specialId, PDO::PARAM_INT, 11);
        $stmt->bindParam('speTitle', $special, PDO::PARAM_STR, 50);
        $stmt->bindParam('days', $daysAllowed, PDO::PARAM_INT, 11);
        $stmt->bindValue('totalPrice', $price);
       
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        return $row_count;
    }
    
    public static function saveOffers($special, $daysAllowed,$price){
        $conn = Database::getDB(); 
        $sql = "INSERT INTO tbl_specials(special, daysAllowed, price)"
                . "VALUES(:speTitle, :days,:totalPrice)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('speTitle', $special, PDO::PARAM_STR, 50);
        $stmt->bindParam('days', $daysAllowed, PDO::PARAM_INT, 11);
        $stmt->bindValue('totalPrice', $price);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        $lastSpeId = $conn->lastInsertId();
        return $lastSpeId;
    }
    
    public static function deleteOffer($offerId){   
        $conn = Database::getDB();      
        $sql = "CALL spDeleteOffer(:offerId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('offerId', $offerId, PDO::PARAM_INT, 11);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        $conn = null;
        return $row_count;
    }
}

?>