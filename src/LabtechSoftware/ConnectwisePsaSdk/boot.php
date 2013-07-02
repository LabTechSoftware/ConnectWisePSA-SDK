<?php 

use LabtechSoftware\ConnectwisePsaSdk\ApiCreds,
    LabtechSoftware\ConnectwisePsaSdk\ApiConfig,
    LabtechSoftware\ConnectwisePsaSdk\ApiResource,
    LabtechSoftware\ConnectwisePsaSdk\ApiException,
    LabtechSoftware\ConnectwisePsaSdk\ApiConnection,
    LabtechSoftware\ConnectwisePsaSdk\ApiRequestParams;

#############################################################################################################################
#############################################################################################################################
################################################## API Bootstrap ############################################################
#############################################################################################################################
#############################################################################################################################

// PHP 5.3+?
if (strnatcmp(phpversion(),'5.3.0') <= 0)
{
    throw new ApiException('PHP v.5.3.0 or higher required for ConnectWise SDK.');
}

// SoapClient class must be available
if (class_exists('SoapClient') !== true)
{
    throw new ApiException('SoapClient class not available.');
}

// SOAP Runtime settings: Turn off cache (0)
// See: http://www.php.net/manual/en/soap.configuration.php
ini_set('soap.wsdl_cache_enabled', '0');
ini_set('soap.wsdl_cache_ttl', '0');

// Set config directory path in the API Config class
ApiConfig::setConfigDirPath(dirname(__FILE__).'/config');

// Set API creds
ApiResource::setResource('api_creds', new ApiCreds);
ApiResource::run('api_creds', 'setUsername', ApiConfig::get('credentials', 'cwusername'));
ApiResource::run('api_creds', 'setPass', ApiConfig::get('credentials', 'cwpass'));
ApiResource::run('api_creds', 'setCompany', ApiConfig::get('credentials', 'company'));
ApiResource::run('api_creds', 'setDomain', ApiConfig::get('credentials', 'domain'));

// Setup API Connection
ApiResource::setResource('api_connection', new ApiConnection);
ApiResource::run('api_connection', 'setAddress', ApiConfig::get('urls', 'cw_api_main'));
ApiResource::run('api_connection', 'setDomain', ApiConfig::get('credentials', 'domain'));
ApiResource::run('api_connection', 'setOptions', ApiConfig::get('soap'));

// Add API creds to connection params
ApiRequestParams::set('credentials', ApiResource::run('api_creds', 'getCredsArray'));