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

}


$db=Database::getDB();
$sql = $db->prepare("select email,firstName,UserId from tbl_users LIMIT 20");
$sql->execute();
$result=$sql->fetchAll();
//$numRows = mysql_num_rows($sql); // Added for "End Campaign Check" at the bottom of this file(not shown on the video)
$mail_body = 'vikas';

foreach ($result as $row){
	$id = $row["UserId"];
	$email = $row["email"];
	$name = $row["firstName"];
	
	$mail_body = '<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body style="background-color:#CCC; color:#000; font-family: Arial, Helvetica, sans-serif; line-height:1.8em;">
        <div style="width:100%;color:#000000;background-color: #5D74C9 ;overflow: auto;">
<h3>Match Found You May Be Interested </h3>
<p>Hello ' . $name . ',</p>
<div style="width: 100px;height: 100px;float: left;background-color: #000;border: 1px solid black;">
   <p>id ' . $id . ',</p>
        <p>Email ' . $email . ',</p>
</div>

<hr>
        </div>
        </body>
</html>';
    $subject = "Develop PHP Newsletter";
    $headers  = "From:vikassangha@yahoo.com\r\n";
    $headers .= "Content-type: text/html\r\n";
    $to = "$email";

    $mail_result = mail($to, $subject, $mail_body, $headers);
	
	
	
}
?>
<?php

?>