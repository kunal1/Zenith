<?php
class Database{
    
    
    private static $user = "vikassangha";
    private static $pass = "vik211283";
    private static $dsn = "mysql:host=my03.winhost.com;dbname=mysql_66299_mydatabase";
    private static $db;
    public static function getDB(){
        if(!isset(self::$db)){
            try{    
            self::$db = new PDO(self::$dsn,self::$user,self::$pass);
            }
            catch(PDOException $e){
                echo "Error occured: " . $e->getMessage();
            }
        }
        return self::$db;
    }

}

?>