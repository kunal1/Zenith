<?php
if ($_SERVER['REQUEST_METHOD'] != "POST") die ("No Post Variables");

$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) 
    {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
    }
$url = "https://sandbox.paypal.com/cgi-bin/webscr";
$curl_result=$curl_err='';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
curl_setopt($ch, CURLOPT_HEADER , 0);   
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$curl_result = @curl_exec($ch);
$curl_err = curl_error($ch);
curl_close($ch);

$req = str_replace("&", "\n", $req);  // Make it a nice list in case we want to email it to ourselves for reporting

// Check that the result verifies
if (strpos($curl_result, "VERIFIED") !== false) {
    $req .= "\n\nPaypal Verified OK";
} else {
	$req .= "\n\nData NOT verified from Paypal!";
	mail("kpatelp@gmail.com", "IPN interaction not verified", "$req", "From: kpatelp@gmail.com" );
	exit();
}

/* CHECK THESE 4 THINGS BEFORE PROCESSING THE TRANSACTION, HANDLE THEM AS YOU WISH
1. Make sure that business email returned is your business email
2. Make sure that the transaction’s payment status is “completed”
3. Make sure there are no duplicate txn_id
4. Make sure the payment amount matches what you charge for items. (Defeat Price-Jacking) */
 
// Check Number 1 ------------------------------------------------------------------------------------------------------------
$receiver_email = $_POST['receiver_email'];
if ($receiver_email != "kpatelp@gmail.com") 
    {
    $message = "Investigate why and how receiver email is wrong. Email = " . $_POST['receiver_email'] . "\n\n\n$req";
    mail("kpatelp@gmail.com", "Receiver Email is incorrect", $message, "From: kpatelp@gmail.com" );
    exit(); // exit script
    }
// Check number 2 ------------------------------------------------------------------------------------------------------------
if ($_POST['payment_status'] != "Completed") 
    {
	
    }
// Connect to database ------------------------------------------------------------------------------------------------------
require_once '../Database.php';
// Check number 3 ------------------------------------------------------------------------------------------------------------
$this_txn = $_POST['txn_id'];
$conn = Database::getDB(); 
$sql = mysql_query("SELECT specialPaymentId FROM tbl_specialpaymenthistory WHERE txn_id=:cspId");
                $stmt=$conn->prepare($sql);
                $stmt->bindParam('cspId',$this_txn,  PDO::PARAM_INT,11);                
                $stmt->execute();
                $rows=$stmt->fetchAll();

$numRows = mysql_num_rows($sql);
if ($numRows > 0) 
    {
    $message = "Duplicate transaction ID occured so we killed the IPN script. \n\n\n$req";
    mail("kpatelp@gmail.com", "Duplicate txn_id in the IPN system", $message, "From: kpatelp@gmail.com" );
    exit(); // exit script
    } 
// Check number 4 ------------------------------------------------------------------------------------------------------------
$product_id_string = $_POST['custom'];
$product_id_string = rtrim($product_id_string, ","); 
// Explode the string, make it an array, then query all the prices out, add them up, and make sure they match the payment_gross amount
$id_str_array = explode(",", $product_id_string); 
$fullAmount = 0;
foreach ($id_str_array as $key => $value) {
    
	$id_quantity_pair = explode("-", $value); // Uses Hyphen(-) as delimiter to separate product ID from its quantity
	$product_id = $id_quantity_pair[0]; // Get the product ID
	$product_quantity = $id_quantity_pair[1]; // Get the quantity
        
//	$sql = mysql_query("SELECT price FROM products WHERE id='$product_id' LIMIT 1");
    while($row = mysql_fetch_array($sql)){
		$product_price = $row["price"];
	}
	$product_price = $product_price * $product_quantity;
	$fullAmount = $fullAmount + $product_price;
}
$fullAmount = number_format($fullAmount, 2);
$grossAmount = $_POST['mc_gross']; 
if ($fullAmount != $grossAmount) {
        $message = "Possible Price Jack: " . $_POST['payment_gross'] . " != $fullAmount \n\n\n$req";
        mail("kpatelp@gmail.com", "Price", $message, "From: kpatelp@gmail.com.com" );
        exit(); // exit script
} 

$txn_id = $_POST['txn_id'];
$custom = $_POST['custom'];
// Place the transaction into the database

 $conn = Database::getDB(); 
        $sql = "INSERT INTO tbl_specialpaymenthistory (product_id_array,paymentDate,txn_id, payment_status)"
                . "VALUES(:customs, :date,:txn,:status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('customs', $custom, PDO::PARAM_STR, 50);
        $stmt->bindParam('date', $payment_date, PDO::PARAM_INT, 11);
        $stmt->bindValue('txn', $txn_id);
        $stmt->bindValue('status', $payment_status);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        $lastSpeId = $conn->lastInsertId();
        return $lastSpeId;

// Mail yourself the details
mail("kpatelp@gmail.com", "NORMAL IPN !", $req, "From: kpatelp@gmail.com");
?>