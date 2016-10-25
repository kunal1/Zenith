<?php
    require_once 'emails.php';
    
    $from = 'Zenith Matrimony <info@jagsirsingh.com>';
    $to = 'Jagsir <jassi.jagsir@gmail.com>';
    
    $subject = 'Hello test';
    
    $body = '<p>This is done</p>';
    $is_body_html = true;
    
    try{
        $emailObj = new emails();
        $emailObj->send_email($to, $from, $subject, $body, $is_body_html);
    } catch (Exception $ex) {
        $error = $e->getMessage();
        echo $error;
    }
    
?>