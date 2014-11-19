#------------------------------------------------------------------
# The export statements below are NOT REQUIRED to run integration
# tests but instead can be set optionally to override the default
# values found in the config.php file included in this package
#------------------------------------------------------------------
# export SOAP_VERSION = 1
# export EXCEPTIONS = true
# export TRACE = 1
# export CACHE_WSDL = 1
# export CW_API_MAIN='https://%s/v4_6_release/apis/1.5/%s.asmx?wsdl'
#------------------------------------------------------------------
# The export statements below are REQUIRED to run integration tests
#------------------------------------------------------------------
export DOMAIN="test.connectwise.com"
export COMPANYID="LabTech"
export INTEGRATORLOGINID="webdev"
export INTEGRATORPASSWORD="webdev"
phpunit --testdox tests/ConnectWise/integration