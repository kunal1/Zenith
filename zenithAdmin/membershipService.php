<?php
require_once '../Database.php';
require_once '../membershipPlansDB.php';
require_once '../commonDB.php';

extract($_REQUEST);

$response;
$result = '';
switch ($data)
{
    case 'updPlan':
        commonDB::chectStrings($result, $membership, 'memTitle');
        commonDB::chectNumbers($result, $daysAllowed, 'days');
        commonDB::chectNumbers($result, $contactsAllowed, 'contacts');
        commonDB::chectDecimal($result, $price, 'price');
        commonDB::chectStrings($result, $comments, 'comments');
            
        if($result == ''){
            $result = membershipPlansDB::updateMembership($membershipId, $membership, $daysAllowed, $contactsAllowed, $price, $comments);  
            if($result)
            {
                $result = true;
            }
            else 
                {
                    $result = false;
                }
        }
        break;
    case 'svPlan':
        commonDB::chectStrings($result, $membership, 'memTitle');
        commonDB::chectNumbers($result, $daysAllowed, 'days');
        commonDB::chectNumbers($result, $contactsAllowed, 'contacts');
        commonDB::chectDecimal($result, $price, 'price');
        commonDB::chectStrings($result, $comments, 'comments');
            
        if($result == ''){
            $result = membershipPlansDB::saveMembership($membership, $daysAllowed, $contactsAllowed, $price, $comments);
        }
        break;
    case 'delPlan':
        $result = membershipPlansDB::deleteMembershipPlan($planId);      
        break;
    default:
        $result = "fail";            
}
echo json_encode($result);
?>