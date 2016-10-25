<?php
require_once '../Database.php'; //import database connection class

class Chatadmin {

    public $tablename = 'tbl_adminchat';

    function SendMessage($msg, $sender) {
        $conn = Database::getDB();

        $query = "INSERT INTO `$this->tablename`(`msg`,`sender`) 
			VALUES ( :msg,:sender)";

        $statement = $conn->prepare($query);
        $statement->bindValue(':msg', $msg, PDO::PARAM_STR);
        $statement->bindValue(':sender', $sender, PDO::PARAM_INT);

        try {
            return $statement->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function mailChat($senderID) {
        $chats = $this->getAll();
        ob_start();
        foreach ($chats as $chatmsg) {
            ?>
            <p>
                <strong><?php echo $chatmsg['sender']; //convert this to the username  ?> <small>Says:</small> </strong><br/>
                <?php echo $chatmsg['msg']; ?>
            </p>       

        <?php
        }
        
        $msg = ob_get_clean();
        $from = 'tunde@humber.com';
        $to = 'get user email here';
        $subject = 'Your chat logs';
        if(mail($to, $subject, $msg)){
            $this->deleteAll();
            return 1;
        }
        
        return 0;
    }

    function getAll($order = 0, $sender = 0) {
        $conn = Database::getDB();
        switch ($order) {
            case 0:
                $order = 'date ASC';
                break;
            case 1:
                $order = 'date DESC';
                break;
        }
        $where = '1';

        if ($sender)
            $where = 'sender = ' . $sender;


        $query = "SELECT * FROM `$this->tablename` WHERE $where ORDER BY $order";
        $statement = $conn->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    function deleteAll(){
        $chats = $this->getAll();
        foreach ($chats as $chat){
            
            $this->delete($chat['id']);
        }
    }
    
    function delete($id) {
        $conn = Database::getDB();
        $query = "DELETE FROM `$this->tablename` WHERE id = :id";
        $statement = $conn->prepare($query);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }

}
?>