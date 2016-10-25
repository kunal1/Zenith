<?php

global $db;
#starting the users session
//session_start();
require_once 'Database.php';
require_once 'userClass.php';
require_once 'generalClass.php';
 
$userClass = new Users($db);
$generalClass = new General();
 
$errors = array();

?>
