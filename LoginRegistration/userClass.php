<?php
class Users
{
    private $db;
 
	public function __construct($database) 
        {
	    $this->db = Database::getDB(); 
	}
        
        public function login($username, $password)
    {
 
	$query = $this->db->prepare("SELECT `password`, `userId` FROM `tbl_users` WHERE `userName` = ?");
	$query->bindValue(1, $username);
	
	try{
		
		$query->execute();
		$data = $query->fetch();
		$stored_password = $data['password'];
		$id = $data['userId'];
		
		
		if($stored_password === $password){
			return $id;	
		}else{
			return false;	
		}
            }
            catch(PDOException $e)
            {
		die($e->getMessage());
            }
    }
 
    
    public function user_exists($username) 
        {
	$query = $this->db->prepare("SELECT COUNT(`userId`) FROM `tbl_users` WHERE `userName`= ?");
	$query->bindValue(1, $username);
 
            try
                {
		$query->execute();
		$rows = $query->fetchColumn();
 
		if($rows == 1)
                    {
			return true;
                    }
                else
                    {
			return false;
                    }
                } 
            catch (PDOException $e)
                {
		die($e->getMessage());
                }
 
       }
    
        public function userdata($id) 
             {
                    $query = $this->db->prepare("SELECT * FROM `tbl_users` WHERE `userId`= ?");
                    $query->bindValue(1, $id);
            try{
		$query->execute();
                return $query->fetch();
                } 
                catch(PDOException $e)
                {
                    die($e->getMessage());
                }
             }
             
             
             
       public function email_exists($email)               
       {
	$query = $this->db->prepare("SELECT COUNT(`userId`) FROM `tbl_users` WHERE `email`= ?");
	$query->bindValue(1, $email);
 
	try
             {
		$query->execute();
		$rows = $query->fetchColumn();
 
		if($rows == 1){
			return true;
		}else{
			return false;
		}
            } 
        catch (PDOException $e)
            {
		die($e->getMessage());
            }
 
       }
       
       
  public function register($textfirst,$textlast,$username, $password, $email,$selected_radio,$age)
  {
	$time = time();
	$ip = $_SERVER['REMOTE_ADDR'];
	$email_code = $username + microtime();
	$password = $password;
        $phone = '647 6485689';
        $roleid = 3;
 
	$query 	= $this->db->prepare("INSERT INTO `tbl_users` (`firstName`, `lastName`, `sex`, `email`, `phone`, `userName`,`password`,`RoleId`,`email_code`,`time`,`ip`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
 
	$query->bindValue(1, $textfirst);
	$query->bindValue(2, $textlast);
	$query->bindValue(3, $selected_radio);
	$query->bindValue(4, $email);
	$query->bindValue(5, $phone );
	$query->bindValue(6, $username);
        $query->bindValue(7, $password);
        $query->bindValue(8, $roleid);
        $query->bindValue(9, $email_code);
        $query->bindValue(10, $time);
        $query->bindValue(11, $ip);
        
        try{
		$query->execute();
 
 //mail($email, 'Please activate your account', "Hello " . $username. ",\r\nThank you for registering with us. Please visit the link below so we can activate your account:\r\n\r\nhttp://www.krunalpatel1.com/phpfinal/website/activate.php?email=" . $email . "&email_code=" . $email_code . "\r\n\r\n-- Zenith");
	}catch(PDOException $e)
        {
		die($e->getMessage());
	}	
       
    $u_id = $this->db->lastInsertId();
   $query1 = $this->db->prepare("INSERT INTO `tbl_userbasicdetails` (`userId`, `gender`, `age`) VALUES (?, ?, ?)");     
        
        $query1->bindValue(1, $u_id);
	$query1->bindValue(2, $selected_radio);
	$query1->bindValue(3, $age);
     
 
	try{
		$query1->execute();
 
 mail($email, 'Please activate your account', "Hello " . $username. ",\r\nThank you for registering with us. Please visit the link below so we can activate your account:\r\n\r\nhttp://www.jagsirsingh.com/zenith/activate.php?email=" . $email . "&email_code=" . $email_code . "\r\n\r\n-- Zenith");
	}catch(PDOException $e){
		die($e->getMessage());
	}	
}
                  public function activate($email, $email_code) 
                {
		
		$query = $this->db->prepare("SELECT COUNT(`userId`) FROM `tbl_users` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");	
	$query->bindValue(1, $email);
		$query->bindValue(2, $email_code);
		$query->bindValue(3, 0);
 
		try{
 
			$query->execute();
			$rows = $query->fetchColumn();
 
			if($rows == 1){
				
				$query_2 = $this->db->prepare("UPDATE `tbl_users` SET `confirmed` = ? WHERE `email` = ?");
 
				$query_2->bindValue(1, 1);
				$query_2->bindValue(2, $email);				
 
				$query_2->execute();
				return true;
 
			}else{
				return false;
			}
 
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}


}

?>
