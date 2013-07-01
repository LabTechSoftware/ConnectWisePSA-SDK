<?php 

#############################################################################################################################
#############################################################################################################################
################################################## API Bootstrap ############################################################
#############################################################################################################################
#############################################################################################################################

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
 * Simple PSR-0 autoloader
 * Uncomment lines 33-59 this to use if not using composer.json for package management
 *
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
 * @return void
 **/
/*
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
    
    $toLoad = dirname(__FILE__).'/'.$fileName;

    if (is_file($toLoad) === true)
    {
        include $toLoad;
    }
}

// Register autoload function
spl_autoload_register('apiAutoloader');
*/

// Set config directory path in the API Config class
ConnectWiseApi\ApiConfig::setConfigDirPath(dirname(__FILE__).'/config');

// Set API creds
ConnectWiseApi\ApiResource::setResource('api_creds', new ConnectWiseApi\ApiCreds);
ConnectWiseApi\ApiResource::run('api_creds', 'setUsername', ConnectWiseApi\ApiConfig::get('credentials', 'cwusername'));
ConnectWiseApi\ApiResource::run('api_creds', 'setPass', ConnectWiseApi\ApiConfig::get('credentials', 'cwpass'));
ConnectWiseApi\ApiResource::run('api_creds', 'setCompany', ConnectWiseApi\ApiConfig::get('credentials', 'company'));
ConnectWiseApi\ApiResource::run('api_creds', 'setDomain', ConnectWiseApi\ApiConfig::get('credentials', 'domain'));

// Setup API Connection
ConnectWiseApi\ApiResource::setResource('api_connection', new ConnectWiseApi\ApiConnection);
ConnectWiseApi\ApiResource::run('api_connection', 'setAddress', ConnectWiseApi\ApiConfig::get('urls', 'cw_api_main'));
ConnectWiseApi\ApiResource::run('api_connection', 'setDomain', ConnectWiseApi\ApiConfig::get('credentials', 'domain'));
ConnectWiseApi\ApiResource::run('api_connection', 'setOptions', ConnectWiseApi\ApiConfig::get('soap'));

// Add API creds to connection params
ConnectWiseApi\ApiRequestParams::set('credentials', ConnectWiseApi\ApiResource::run('api_creds', 'getCredsArray'));
