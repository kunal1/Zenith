<?php
require_once '../Database.php';
require_once '../specialOffersDB.php';

extract($_REQUEST);

$response;
$result;
switch ($data)
{
    case 'updOffer':
        $response = specialOffersDB::updateOffers($specialId, $special,$daysAllowed, $price);
        if($response)
        {
            $result = $response;
        }
        else 
            {
                $result = $response;
            }
        break;
    case 'svOffer':
        $result = specialOffersDB::saveOffers($special, $daysAllowed, $price);
        break;
      case 'delOffer':
        $result = specialOffersDB::deleteOffer($offerId);      
        break;
    
    default:
        $result = "fail";            
}
echo json_encode($result);
?>