<?php

require_once '../Database.php'; //import database connection class

class Chatrequest {
    /*
     * status 0 - not approved
     * status 1 - approved
     * status 2 - closed chat
     */

    public $tablename = 'tbl_chatrequest';

    function SendRequest($msg, $sender, $status = 0) {
        $conn = Database::getDB();

        $query = "INSERT INTO `$this->tablename`(`msg`,`sender`,`status`) 
			VALUES ( :msg,:sender,:status)";

        $statement = $conn->prepare($query);
        $statement->bindValue(':msg', $msg, PDO::PARAM_STR);
        $statement->bindValue(':sender', $sender, PDO::PARAM_INT);
        $statement->bindValue(':status', $status, PDO::PARAM_INT);

        try {
            return $statement->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function isAproved($sender = 0) {
        $conn = Database::getDB();
        $where = '`status` = 1';
        if ($sender)
            $where .= " AND `sender` = $sender";

        $query = "SELECT status FROM  `$this->tablename` WHERE $where";

        $statement = $conn->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        return !empty($result);
    }

    function isPending($sender = 0) {
        $conn = Database::getDB();
        $where = '`status` = 0';
        if ($sender)
            $where .= " AND `sender` = $sender";

        $query = "SELECT status FROM  `$this->tablename` WHERE $where";

        $statement = $conn->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        return !empty($result);
    }

    function isExists($req_id, $sender = 0) {
        $conn = Database::getDB();
        $where = "`id` = $req_id";
        if ($sender)
            $where .= " AND `sender` = $sender";

        $query = "SELECT status FROM  `$this->tablename` WHERE $where";

        $statement = $conn->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        return !empty($result);
    }

    function getPending($sender = 0) {
        $conn = Database::getDB();
        $where = '`status` = 0';
        if ($sender)
            $where .= " AND `sender` = $sender";

        $query = "SELECT * FROM  `$this->tablename` WHERE $where LIMIT 1";

        $statement = $conn->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    function getSenderID($rid) {
        $conn = Database::getDB();


        $query = "SELECT sender FROM  `$this->tablename` WHERE `id` = $rid";

        $statement = $conn->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        return $result['sender'];
    }

    function where($cond) {
        $where = $cond;
        $c = 0;
        if (is_array($cond)) {
            $where = '';
            foreach ($cond as $key => $val) {
                $where .= $key . ' = ' . $val;
                $c++;
                if ($c != count($cond))
                    $where .= ' AND';
            }
        }

        return $where;
    }

    function set($fields) {
        $set = $fields;
        $c = 0;
        if (is_array($fields)) {
            $set = '';
            foreach ($fields as $key => $val) {
                $set .= $key . ' = ' . $val;
                $c++;
                if ($c != count($fields))
                    $set .= ' ,';
            }
        }

        return $set;
    }

    function update($fields, $cond) {
        $conn = Database::getDB();
        $where = $cond;
        $set  = $fields;
                
        if (is_array($cond))
            $where = $this->where($cond);
        if (is_array($fields))
            $set = $this->set($fields);

        $query = "UPDATE `$this->tablename` SET $set WHERE $where";
        $statement = $conn->prepare($query);
        return $statement->execute();
    }
    function close($rid) {
        $conn = Database::getDB();
        

        $query = "UPDATE `$this->tablename` SET status = 2 WHERE id = $rid";
        $statement = $conn->prepare($query);
        return $statement->execute();
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
            case 2:
                $order = 'status ASC';
                break;
            case 3:
                $order = 'status DESC';
                break;
        }
        $where = '`status` != 2';

        if ($sender)
            $where .= ' AND sender = ' . $sender;


        $query = "SELECT * FROM `$this->tablename` WHERE $where ORDER BY $order";
        $statement = $conn->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
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