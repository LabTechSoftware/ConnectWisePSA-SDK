<?php

return array (
    'soap' => [
        'soap_version' => SOAP_1_1,
        'exceptions' => true,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE,
        'features' => SOAP_SINGLE_ELEMENT_ARRAYS
    ],
    'url' => [
        'cw_api_main' => 'https://%s/v4_6_release/apis/1.5/%s.asmx?wsdl'
    ],
    'credentials' => [
        'domain' => '',
        'CompanyId' => '',
        'IntegratorLoginId' => '',
        'IntegratorPassword' => ''
    ]
);
