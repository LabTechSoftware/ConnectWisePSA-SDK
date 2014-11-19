<?php

use LabtechSoftware\ConnectwisePsaSdk\ConfigLoader;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;

/**
 * Class ConfigLoaderTest
 *
 * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader
 */
class ConfigLoaderTest extends PHPUnit_Framework_TestCase
{
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new ConfigLoader;
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::loadConfig
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage Expecting string or array value.
     */
    public function testLoadConfigThrowsExceptionWhenConfigIsNeitherStringNorArray()
    {
        $this->fixture->loadConfig(null);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::isValidPath
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage Config file not found.
     */
    public function testLoadConfigThrowsExceptionWhenConfigFileDoesNotExist()
    {
        $this->fixture->loadConfig('path/to/non/existant/file.php');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::load
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage config file is not formatted correctly
     */
    public function testLoadThrowsExceptionWhenConfigFileIsNotFormattedCorrectly()
    {
        vfsStream::setup('root');
        $file = vfsStream::url('root/config.php');
        file_put_contents($file, 'Boo on invalid config file formats like this one.');

        $this->fixture->loadConfig($file);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage Configuration array must be indexed with soap and its type must be array
     */
    public function testValidateConfigItemsThrowsExceptionWhenSoapIsMissing($configValues)
    {
        unset($configValues['soap']);
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage Configuration array must be indexed with soap and its type must be array
     */
    public function testValidateConfigItemsThrowsExceptionWhenSoapIsNotAnArray($configValues)
    {
        $configValues['soap'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage soap array must be indexed with soap_version and its type must be integer
     */
    public function testValidateConfigItemsThrowsExceptionWhenSoapVersionIsMissing($configValues)
    {
        unset($configValues['soap']['soap_version']);
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage soap array must be indexed with soap_version and its type must be integer
     */
    public function testValidateConfigItemsThrowsExceptionWhenSoapVersionIsNotAnInteger($configValues)
    {
        $configValues['soap']['soap_version'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage soap array must be indexed with exceptions and its type must be boolean
     */
    public function testValidateConfigItemsThrowsExceptionWhenExceptionsIsMissing($configValues)
    {
        unset($configValues['soap']['exceptions']);
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage soap array must be indexed with exceptions and its type must be boolean
     */
    public function testValidateConfigItemsThrowsExceptionWhenExceptionsIsNotBoolean($configValues)
    {
        $configValues['soap']['exceptions'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage soap array must be indexed with trace and its type must be integer
     */
    public function testValidateConfigItemsThrowsExceptionWhenTraceIsMissing($configValues)
    {
        unset($configValues['soap']['trace']);
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage soap array must be indexed with trace and its type must be integer
     */
    public function testValidateConfigItemsThrowsExceptionWhenTraceIsNotAnInteger($configValues)
    {
        $configValues['soap']['trace'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage soap array must be indexed with cache_wsdl and its type must be integer
     */
    public function testValidateConfigItemsThrowsExceptionWhenCacheWsdlIsMissing($configValues)
    {
        unset($configValues['soap']['cache_wsdl']);
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage soap array must be indexed with cache_wsdl and its type must be integer
     */
    public function testValidateConfigItemsThrowsExceptionWhenCacheWsdlIsNotAnInteger($configValues)
    {
        $configValues['soap']['cache_wsdl'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage Configuration array must be indexed with url and its type must be array
     */
    public function testValidateConfigItemsThrowsExceptionWhenUrlIsMissing($configValues)
    {
        unset($configValues['url']);
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage Configuration array must be indexed with url and its type must be array
     */
    public function testValidateConfigItemsThrowsExceptionWhenUrlIsNotAnArray($configValues)
    {
        $configValues['url'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage url array must be indexed with cw_api_main and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenCwApiMainIsMissing($configValues)
    {
        unset($configValues['url']['cw_api_main']);
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage url array must be indexed with cw_api_main and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenCwApiMainIsNotAString($configValues)
    {
        $configValues['url']['cw_api_main'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage url array must be indexed with cw_api_main and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenCwApiMainIsAnEmptyString($configValues)
    {
        $configValues['url']['cw_api_main'] = '';
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage Configuration array must be indexed with credentials and its type must be array
     */
    public function testValidateConfigItemsThrowsExceptionWhenCredentialsIsMissing($configValues)
    {
        unset($configValues['credentials']);
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage Configuration array must be indexed with credentials and its type must be array
     */
    public function testValidateConfigItemsThrowsExceptionWhenCredentialsIsNotAnArray($configValues)
    {
        $configValues['credentials'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage credentials array must be indexed with domain and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenDomainIsMissing($configValues)
    {
        unset($configValues['credentials']['domain']);
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage credentials array must be indexed with domain and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenDomainIsNotAString($configValues)
    {
        $configValues['credentials']['domain'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage credentials array must be indexed with domain and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenDomainIsAnEmptyString($configValues)
    {
        $configValues['credentials']['domain'] = '';
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage credentials array must be indexed with CompanyId and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenCompanyIdIsMissing($configValues)
    {
        unset($configValues['credentials']['CompanyId']);
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage credentials array must be indexed with CompanyId and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenCompanyIdIsNotAString($configValues)
    {
        $configValues['credentials']['CompanyId'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage credentials array must be indexed with CompanyId and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenCompanyIdIsAnEmptyString($configValues)
    {
        $configValues['credentials']['CompanyId'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage credentials array must be indexed with IntegratorLoginId and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenIntegratorLoginIdIsMissing($configValues)
    {
        unset($configValues['credentials']['IntegratorLoginId']);
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage credentials array must be indexed with IntegratorLoginId and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenIntegratorLoginIdIsNotAString($configValues)
    {
        $configValues['credentials']['IntegratorLoginId'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage credentials array must be indexed with IntegratorLoginId and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenIntegratorLoginIdIsAnEmptyString($configValues)
    {
        $configValues['credentials']['IntegratorLoginId'] = '';
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage credentials array must be indexed with IntegratorPassword and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenIntegratorPasswordIsMissing($configValues)
    {
        unset($configValues['credentials']['IntegratorPassword']);
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage credentials array must be indexed with IntegratorPassword and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenIntegratorPasswordIsNotAString($configValues)
    {
        $configValues['credentials']['IntegratorPassword'] = null;
        $this->fixture->loadConfig($configValues);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConfigLoader::validateConfigItems
     * @dataProvider validConfigItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage credentials array must be indexed with IntegratorPassword and its type must be string
     */
    public function testValidateConfigItemsThrowsExceptionWhenIntegratorPasswordIsAnEmptyString($configValues)
    {
        $configValues['credentials']['IntegratorPassword'] = '';
        $this->fixture->loadConfig($configValues);
    }
    /**
     * @return array
     */
    public function validConfigItems()
    {
        return [
            [
                [
                    'soap' => [
                        'soap_version' => 1,
                        'exceptions' => true,
                        'trace' => 1,
                        'cache_wsdl' => 1,
                    ],
                    'url' => [
                        'cw_api_main' => 'cw_api_main'
                    ],
                    'credentials' => [
                        'domain' => 'domain',
                        'CompanyId' => 'CompanyId',
                        'IntegratorLoginId' => 'IntegratorLoginId',
                        'IntegratorPassword' => 'IntegratorPassword'
                    ]
                ]
            ]
        ];
    }
}