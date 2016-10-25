<?php

/* Author: Jagsir Singh
 * 
 */

require_once 'Mail.php';
require_once 'Mail/RFC822.php';
class emails {
    function send_email($to, $subject, $body, $is_body_html = false){
//        if(!$this->valid_email($to)){
//            throw new Exception('This To address is invalid: ' . htmlspecialchars($to));
//        }
//        
//        if(!$this->valid_email($from)){
//            throw new Exception('This From address is invalid: ' . htmlspecialchars($from));
//        }
        
        $from = 'Zenith Matrimony <info@jagsirsingh.com>';
        $smtp = array();
        $smtp['host'] = 'mail.jagsirsingh.com';
        $smtp['auth'] = true;
        $smtp['username'] = 'info@jagsirsingh.com';
        $smtp['password'] = 'jagsir2014';
        
        $mailer = Mail::factory('smtp', $smtp);
        if(PEAR::isError($mailer)){
            throw new Exception('could not create mailer.');
        }
        
        $recipients = array();
        $recipients[] = $to;
        
        $headers = array();
        $headers['From'] = $from;
        $headers['To'] = $to;
        $headers['Subject'] = $subject;
        if($is_body_html){
            $headers['Content-type'] = 'text/html';
        }
        $result = $mailer->send($recipients,$headers,$body);
        
        if(PEAR::isError($result)){
            throw new Exception('Error sending email: ' . htmlspecialchars($result->getMessage()));
        } 
    }
        
        function valid_email($email){
            $emailObjects = Mail_RFC822::parseAddressList($email);
            if(PEAR::isError($emailObjects)){
                return false;
            }
            
            $mailbox = $emailObjects[0]->mailbox;
            $host = $emailObjects[0]->host;
            
            if(strlen($mailbox)>64){
                return false;
            }
            if(strlen($host)>255){
                return false;
            }
            
            $atom = '[[:alnum:]_!#$%&\'*+\/=?^{|}~-]+';
            $dotatom = '(\.' . $atom . ')*';
            $address = '(^' . $atom . $dotatom . '$)';
            $char = '([^\\\\"])';
            $esc = '(\\\\[\\\\"])';
            $text = '(' . $char . '|' .$esc . ')+';
            $quoted = '(^"' . $text . '"$)';
            $localPart = '/' . $address . '|' . $quoted . '/';
            $localMatch = preg_match($localPart, $mailbox);
            if($localMatch === false || $localMatch != 1){
                return false;
            }
            
            $hostname = '([[:alnum:]]([-[:alnum:]]{0,62}[[:alnum:]])?)';
            $hostname = '(' . $hostname . '(\.' . $hostname . ')*)';
            $top = '\.[[:alnum:]]{2,6}';
            $domainPart = '/^' . $hostnames . $top . '$/';
            $domainMatch = preg_match($domainPart, $host);
            if($domainMatch === false || $domainMatch != 1){
                return false;
            }
            return true;
        }
}
