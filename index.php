<?php

error_reporting(E_ALL);

include dirname(__FILE__)."/ConnectWisePSA_SDK/ConnectWisePSABase.php";

define('CW_ROOT_DOMAIN', '');
define('CW_COMPANY', '');
define('CW_INTEGREATOR_USERNAME', '');
define('CW_INTEGREATOR_PASSWORD', '');


$cw = new ConnectWisePSA\ContactAPI();

$results = $cw->test("hehe", "haha");

print_r($results);

?>