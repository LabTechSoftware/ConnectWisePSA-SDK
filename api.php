<?php 

##################################################################################################################################
##################################################################################################################################
################################################## API Bootstrap #################################################################
##################################################################################################################################
##################################################################################################################################

// PHP 5.3+?
if (strnatcmp(phpversion(),'5.3.0') <= 0)
{
    throw new Exception('PHP v.5.3.0 or higher required for ConnectWise SDK.');
}

// SoapClient class must be available
if (class_exists('SoapClient') !== true)
{
    throw new Exception('SoapClient class not available.');
}

// SOAP Runtime settings: Turn off cache (0)
// See: http://www.php.net/manual/en/soap.configuration.php
ini_set('soap.wsdl_cache_enabled', '0');
ini_set('soap.wsdl_cache_ttl', '0');

/**
 * Simple autoloader
 *
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
 * @return mixed
 **/
function apiAutoloader($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    
    if ($lastNsPos = strripos($className, '\\')) 
    {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    require $fileName;
}

// Register autoload function
spl_autoload_register('apiAutoloader');

// Set config directory path in the API Config class
Api\ApiConfig::setConfigDirPath(dirname(__FILE__).'/config');

// Set API creds
Api\ApiResource::setResource('api_creds', new Api\ApiCreds);
Api\ApiResource::run('api_creds', 'setUsername', Api\ApiConfig::get('credentials', 'cwusername'));
Api\ApiResource::run('api_creds', 'setPass', Api\ApiConfig::get('credentials', 'cwpass'));
Api\ApiResource::run('api_creds', 'setCompany', Api\ApiConfig::get('credentials', 'company'));
Api\ApiResource::run('api_creds', 'setDomain', Api\ApiConfig::get('credentials', 'domain'));

// Setup API Connection
Api\ApiResource::setResource('api_connection', new Api\ApiConnection);
Api\ApiResource::run('api_connection', 'setAddress', Api\ApiConfig::get('urls', 'cw_api_main'));
Api\ApiResource::run('api_connection', 'setDomain', Api\ApiConfig::get('credentials', 'domain'));
Api\ApiResource::run('api_connection', 'setOptions', Api\ApiConfig::get('soap'));

// Add API creds to connection params
Api\ApiRequestParams::set('credentials', Api\ApiResource::run('api_creds', 'getCredsArray'));
