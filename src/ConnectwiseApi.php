<?php namespace LabtechSoftware\ConnectwisePsaSdk;

use SoapClient,
    LabtechSoftware\ConnectwisePsaSdk\Support\Config,
    LabtechSoftware\ConnectwisePsaSdk\Support\ApiException,
    LabtechSoftware\ConnectwisePsaSdk\ConnectionTypes\Soap as SoapType;

/**
 * ConnectWise API
 *
 * @package ConnectwisePsaSdk
 */
class ConnectwiseApi
{
    /**
     * Config class instance
     *
     * @var LabtechSoftware\ConnectwisePsaSdk\Support\Config
     **/
    private $config = '';

    /**
     * Set 'er up
     * Check PHP version and SoapClient, then load the config file
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @return void
     **/
    public function __construct($config=null)
    {
        $config = $config ? $config : __DIR__.'/config/config.ini';

        // PHP 5.3+?
        if (strnatcmp(phpversion(),'5.3.0') <= 0) {
            throw new ApiException(
                'PHP v5.3.0 or higher required for ConnectWise SDK.'
            );
        }

        // SoapClient class must be available
        if (class_exists('SoapClient') !== true) {
            throw new ApiException('SoapClient class not available.');
        }

        // Create a new config instance, pass in path to config file
        $this->config = new Config($config);
    }

    /**
     * Set up the API for usage
     *
     * @return ConnectionInterface
     **/
    protected function setupConnection($api)
    {
        // Get entire config array since we'll need nested items
        $config = $this->config->all();

        // Glue together the SOAP Connection details
        $connectionApi = sprintf(
            $config['url']['cw_api_main'],
            $config['credentials']['domain'],
            $api
        );

        // Create new SoapClient instance w/ our config data
        $makeConnection = new SoapClient($connectionApi, $config['soap']);

        return new SoapType($makeConnection, $config['credentials']);
    }

    /**
     * Contact API
     *
     * @return LabtechSoftware\ConnectwisePsaSdk\Contact
     */
    public function contact()
    {
        return new Contact($this->setupConnection('ContactAPI'));
    }

    /**
     * Company API
     *
     * @return LabtechSoftware\ConnectwisePsaSdk\Company
     */
    public function company()
    {
        return new Company($this->setupConnection('CompanyAPI'));
    }

    /**
     * Configuration API
     *
     * @return LabtechSoftware\ConnectwisePsaSdk\Configuration
     */
    public function configuration()
    {
        return new Configuration($this->setupConnection('ConfigurationAPI'));
    }

    /**
     * Reporting API
     *
     * @return LabtechSoftware\ConnectwisePsaSdk\Reporting
     */
    public function reporting()
    {
        return new Reporting($this->setupConnection('ReportingAPI'));
    }

    /**
     * Service Ticket API
     *
     * @return LabtechSoftware\ConnectwisePsaSdk\ServiceTicket
     */
    public function serviceTicket()
    {
        return new ServiceTicket($this->setupConnection('ServiceTicketApi'));
    }
}
