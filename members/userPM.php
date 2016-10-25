<?php
require_once '../Database.php';//import database connection class
class userPM {

    /**
     * @return Int 0		Message sent successfully
     * @return Int 1		No title
     * @return Int 2		No body
     * @return Int 3		Invalid Sender
     * @return Int 4		Invalid Receiver
     * @return Int 5		Invalid Sender Level
     * @return Int 6		Error inputing in Database
     *
     * @param String $title
     * @param String $body
     * @param Int $sender
     * @param Int $receiver
     *
     * @desc Send messege to $receiver
     */
    function SendMessage($title, $body, $sender, $receiver) {
        $conn = Database::getDB();
        if (strlen($title) == 0)
            return 1;
        if (strlen($body) == 0)
            return 2;
        if (strlen($sender) == 0)
            return 3;
        if (strlen($receiver) == 0)
            return 4;
        
        $query = 'INSERT INTO `tbl_privatemessage`(`title`,`body`,`sender`,`receiver`,`read`) 
			VALUES ( :title,:body,:sender,:receiver,0)';
        //VALUES ( :title,:body,:sender,:receiver,0)
        $statement = $conn->prepare($query);
        $statement->bindValue(':title', $title,PDO::PARAM_STR);
        $statement->bindValue(':body', $body,PDO::PARAM_STR);
        $statement->bindValue(':sender', $sender,PDO::PARAM_INT);
        $statement->bindValue(':receiver', $receiver,PDO::PARAM_INT);
       
        
        try{
            $row = $statement->execute();
		//$query->execute();
 
 //mail($email, 'Please activate your account', "Hello " . $username. ",\r\nThank you for registering with us. Please visit the link below so we can activate your account:\r\n\r\nhttp://www.krunalpatel1.com/phpfinal/website/activate.php?email=" . $email . "&email_code=" . $email_code . "\r\n\r\n-- Zenith");
	}catch(PDOException $e)
        {
		
                var_dump($e->getMessage());die();
	}
       //return $row;
        if ($row)
            return 0;
        else
            return 6;
    }

    /**
     * @return int 1		 When msgId equal to 0
     * @return int 2      When no Messege in database with that msgId
     * @return String 	 Returns the title of the messege
     * @param int $msgId
     * @desc This function is used to return the title of a specific message
     */
    function GetTitle($msgId) {
        $conn = Database::getDB();
        if (strlen($msgId) == 0)
            return 1;
        $query = 'SELECT title FROM tbl_privatemessage WHERE idMsg = :msgId';

        $statement = $conn->prepare($query);
        $statement->bindValue(':msgId', $msgId);
        $statement->execute();
        if ($statement->rowCount() == 0)
            return 2;
        $result = $statement->fetch();

        return $result->title;
    }

    /**
     * @return int 1		When msgId equal to 0
     * @return int 2		When no Messege in database with that msgId
     * @return String 	Returns the body of the messege
     * @param int $msgId
     * @desc This function is used to return the body of a especific messege
     */
    function GetBody($msgId) {
        $conn = Database::getDB();
        if (strlen($msgId) == 0)
            return 1;
        $query = 'SELECT body FROM tbl_privatemessage WHERE idMsg =:$msgId';

        $statement = $conn->prepare($query);
        $statement->bindValue(':msgId', $msgId);
        $statement->execute();
        if ($statement->rowCount() == 0)
            return 2;
        $result = $statement->fetch();

        return $result->body;
    }

    /**
     * @return int 1				When msgId equal to 0
     * @return int 2				When no Messege in database with that msgId
     * @return int Other int 	Return the userId that sent this messege
     * @param int $msgId
     * @desc This function is used to return the userId from the sender of a especific messege
     */
    function GetSenderID($msgId) {
        $conn = Database::getDB();
        if (strlen($msgId) == 0)
            return 1;
        $query = 'SELECT sender FROM tbl_privatemessage WHERE idMsg = :msgId';

        $statement = $conn->prepare($query);
        $statement->bindValue(':msgId', $msgId);
        $statement->execute();
        if ($statement->rowCount() == 0)
            return 2;
        $result = $statement->fetch();

        return $result->sender;
    }

    /**
     * @return int 1				When msgId equal to 0
     * @return int 2				When no Messege in database with that msgId
     * @return int Other int 	Return the userId that is the receiver this messege
     * @param int $msgId
     * @desc This function is used to return the userId from the receiver of a especific messege
     */
    function GetReceiverID($msgId) {
        $conn = Database::getDB();
        if (strlen($msgId) == 0)
            return 1;
        $query = 'SELECT receiver FROM tbl_privatemessage WHERE idMsg = :msgId';

        $statement = $conn->prepare($query);
        $statement->bindValue(':msgId', $msgId);
        $statement->execute();
        if ($statement->rowCount() == 0)
            return 2;
        $result = $statement->fetch();

        return $result->receiver;
    }

    /**
     * @return int 1				When msgId equal to 0
     * @return int 2				When no Messege in database with that msgId
     * @return int Other int 	Return the date when the message was sent
     * @param int $msgId
     * @desc This function is used to return the send date of a especific messege
     */
    function GetSendDate($msgId) {
        $conn = Database::getDB();
        if (strlen($msgId) == 0)
            return 1;
        $query = 'SELECT date FROM tbl_privatemessage WHERE idMsg = :msgId';

        $statement = $conn->prepare($query);
        $statement->bindValue(':msgId', $msgId);
        $statement->execute();
        if ($statement->rowCount() == 0)
            return 2;
        $result = $statement->fetch();

        return $result->date;
    }

    /**
     * @return int 1		When msgId equal to 0
     * @return int 2		When no Messege in database with that msgId
     * @return array 	Returns the an array with all the fields of the table were messeges are stored
     * @param int $msgId
     * @desc This function is used to return the messege, and all is specifications
     */
    function GetMessage($msgId) {
        $conn = Database::getDB();
        $message = array();
        if (strlen($msgId) == 0)
            return 1;
        $query = 'SELECT * FROM `tbl_privatemessage` WHERE `idMsg` = :msgId';

        $statement = $conn->prepare($query);
        $statement->bindValue(':msgId', $msgId);
        $statement->execute();
        if ($statement->rowCount() == 0)
            return 2;
       // $result = $statement->fetch();
        return  $statement->fetch();

//        $message['receiver'] = $result->receiver;
//        $message['sender'] = $result->sender;
//        $message['title'] = $result->title;
//        $message['body'] = $result->body;
//        $message['senderLevel'] = $result->senderLevel;
//        $message['read'] = $result->read;
//        $message['date'] = $result->date;

       // return $message;
    }

    /**
     * @return Int 0		Marked Readed succesfully
     * @return Int 1		When msgId equal to 0
     * @return Int 2		Error while updating database
     * @param unknown $msgId
     * @desc Marks the messege has readed
     */
    function MarkAsRead($msgId) {
        $conn = Database::getDB();
        if (strlen($msgId) == 0)
            return 1;
        $query = 'UPDATE `tbl_privatemessage` SET `read` = 1 WHERE `idMsg` = :msgId';
        $statement = $conn->prepare($query);
        $statement->bindValue(':msgId', $msgId);
        $result = $statement->execute();

        if ($result)
            return 0;
        else
            return 2;
    }

    
    function getAll($order = 0, $sender = 0, $receiver = 0){
        
        $conn = Database::getDB();
        switch ($order) {
            case 0:
                $order = 'senderLevel DESC';
                break;
            case 1:
                $order = 'senderLevel ASC';
                break;
            case 2:
                $order = 'read DESC';
                break;
            case 3:
                $order = 'read ASC';
                break;
        }
        $where = '2';
        if ($receiver)
            $where = ' receiver = '.$receiver;
        
        if ($sender)
            $where .= ' AND sender = '.$sender;
        
       
        $query = "SELECT * FROM `tbl_privatemessage` WHERE $where ORDER BY $order";
        $statement = $conn -> prepare($query);
        $statement -> execute();
        return $statement -> fetchAll();
        
    }
        function GetAllMessages($order = 0, $receiver = '', $sender = '') {
        $conn = Database::getDB();
        switch ($order) {
            case 1:
                $order = 'read ASC';
            case 2:
                $order = 'read DESC';
        }
        $where = '';
        if (strlen($receiver) > 0 && strlen($sender) > 0)
            $where = ' AND ';

        $where = ((strlen($receiver) > 0) ? 'receiver=' . $receiver : '') . $where . ((strlen($sender) > 0) ? 'sender=' . $sender : '');

        $result = 'SELECT * FROM tbl_privatemessage WHERE $where ORDER BY $order';

        if (!$result)
            return 1;
        echo $num = mysql_num_rows($result);
        $message = '';
        for ($i = 0; $i < $num; $i++) {
            $row = mysql_fetch_object($result);
            $message[$i]['receiver'] = $row->receiver;
            $message[$i]['sender'] = $row->sender;
            $message[$i]['title'] = $row->title;
            $message[$i]['body'] = $row->body;
            $message[$i]['read'] = $row->read;
            $message[$i]['date'] = $row->date;
        }
        if (!is_array($message))
            return 2;
        return $message;
    }

    /**
     * @return Int 0		Deleted succesfully
     * @return Int 1		When msgId equal to 0
     * @return Int 2		Error while deleting from database
     * @param Int $msgId
     * @desc Delete messege
     */
    function DeleteMessage($msgId) {
        $conn = Database::getDB();
        if (strlen($msgId) == 0)
            return 1;
        $query = 'DELETE FROM tbl_privatemessage WHERE idMsg = :msgId';
        $statement = $conn->prepare($query);
        $statement->bindValue(':msgId', $msgId);
        $result = $statement->execute();
        if ($result)
            return 0;
        else
            return 2;
    }

    function getReceiver() {
        $conn = Database::getDB();
        $query = 'SELECT userId, userName FROM tbl_users WHERE RoleId = 1 OR 3';
        $statement = $conn -> prepare($query);
        $statement -> execute();
        
        $recdetails = $statement->fetchAll();

        return $recdetails;
        }

    function gettheReceiver() {
        $conn = Database::getDB();
        
        $query = 'SELECT userName FROM tbl_users JOIN tbl_privatemessage ON tbl_users.userId = tbl_privatemessage.sender LIMIT 0,1';
        $statement = $conn -> prepare($query);
        $statement -> execute();
        
        $recdetails = $statement->fetchAll();
        
        return $recdetails;
        }
    
} 

?>