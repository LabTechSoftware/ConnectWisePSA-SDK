<?php

include dirname(__FILE__)."/ConnectWisePSA_SDK/ConnectWisePSA.php";

define('CW_ROOT_DOMAIN', '');
define('CW_COMPANY', '');
define('CW_INTEGREATOR_USERNAME', '');
define('CW_INTEGREATOR_PASSWORD', '');





$cw = new CWServiceTicketApiAPI();


$params['limit'] = 100;
$results = $cw->FindServiceTickets($params);



echo "<pre>";
print_r($results);


?>