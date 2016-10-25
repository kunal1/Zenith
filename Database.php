<?php
class Database{
    private static $user = "matrimony";
    private static $pass = "zenith@humber";
    private static $dsn = "mysql:host=my02.winhost.com;dbname=mysql_65818_matrimony";
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



//first method : getCountries to get list of all countries
    public static function getCountries() {
     
        $conn = Database::getDB();

        $qy = "SELECT countryName FROM tbl_country;";

        $cds = $conn->query($qy);
        $count = $conn->exec($qy);
        echo "rows selected :" . $count;
        
        $country = array();
        foreach ($cds as $cd) {

            $country[] = $cd;
        }
        
        return $country;
        
    }
    public static function getRe() 
            {
     
        $con = Database::getDB();

        $qyr = "SELECT religion FROM tbl_religions;";

        $rs = $con->query($qyr);
        $counts = $con->exec($qyr);
        echo "rows selected :" . $counts;
        
        $religion = array();
        foreach ($rs as $r) {

            $religion[] = $r;
        }
        
        return $religion;
        
    }
    
}
?>
