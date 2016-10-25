<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of supportTicketsDB
 *
 * @author Jagsir Singh
 */
include_once 'Database.php';

class supportTicketsDB {
    
    public function getSUserTickets($userId){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserTickets(:UsersId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    
    public function getTicketDetails($ticketId){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetTicketDetails(:ticketId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('ticketId', $ticketId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    
    public  static function closeTicket($ticketId){
        $conn = Database::getDB(); 
        $sql = "CALL spCloseTicket(:ticketId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('ticketId', $ticketId, PDO::PARAM_INT, 11);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        $conn = null;
        return $row_count;
    }   
    
    public  static function saveNewTicket($userId, $subject, $submitDate, $departmentId, $message){
        $conn = Database::getDB(); 
        $sql = "CALL spSaveNewTicket(:senderId, :sub, :subDate, :depId, :msg )";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('senderId', $userId, PDO::PARAM_INT, 11);
        $stmt->bindParam('sub', $subject, PDO::PARAM_STR, 50);
        $stmt->bindValue('subDate', $submitDate);
        $stmt->bindParam('depId', $departmentId, PDO::PARAM_INT, 11);
        $stmt->bindParam('msg', $message, PDO::PARAM_STR, 500);
        $row_count = $stmt->execute();
        $newTicketId = $stmt->fetch();
        $stmt->closeCursor();
        $conn = null;
        return $newTicketId['newTicketId'];
    }   
    
    public  static function saveTicketReply($ticketId, $userId, $submitDate, $message, $isReplied){
        $conn = Database::getDB(); 
        $sql = "CALL spSaveTicketReply(:ticketId, :senderId, :subDate, :msg, :isRep )";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('ticketId', $ticketId, PDO::PARAM_INT, 11);
        $stmt->bindParam('senderId', $userId, PDO::PARAM_INT, 11);
        $stmt->bindValue('subDate', $submitDate);
        $stmt->bindParam('msg', $message, PDO::PARAM_STR, 500);
        $stmt->bindParam('isRep', $isReplied, PDO::PARAM_BOOL);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        $conn = null;
        return $row_count;
    }   
    
    public static function getDepartments(){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetDepartments()";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    
    public static function getAllTickets($departmentId){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetAllTickets(:depId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('depId', $departmentId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    
    public static function getUserEmailByUserId($userId){  
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserEmailByUserId(:UsersId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
    
    public static function getUserEmailByTicketId($ticketId){  
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserEmailByTicketId(:tktId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('tktId', $ticketId, PDO::PARAM_INT, 11);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    }
}
