<?php namespace ConnectWiseApi;

use ConnectWiseApi\ApiException;

/**
 * API Credentials Container
 *
 * @package API
 */
class ApiCreds
{
    protected $apiCreds = array();
    private $_userName = null;
    private $_userPass = null;
    private $_userCompany = null;
    private $_userDomain = null;

    /**
     * Set the API username
     *
     * @throws ApiException
     * @param string $apiUsername
     * @return ApiCreds
     **/
    public function setUsername($apiUsername = null)
    {
        if (is_string($apiUsername) === false)
        {
            throw new ApiException('API username must be a string.');
        }

        $this->_userName = $apiUsername;
        return $this;
    }

    /**
     * Set the API password
     *
     * @throws ApiException
     * @param string $apiPassword
     * @return ApiCreds
     **/
    public function setPass($apiPassword = null)
    {
        if (is_string($apiPassword) !== true)
        {
            throw new ApiException('API password not properly formatted.');
        }

        $this->_userPass = $apiPassword;
        return $this;
    }

    /**
     * Set the Company ID
     *
     * @throws ApiException
     * @param string $apiCompany
     * @return ApiCreds
     **/
    public function setCompany($apiCompany = null)
    {
        if (is_string($apiCompany) !== true)
        {
            throw new ApiException('API company must be a string.');
        }

        $this->_userCompany = $apiCompany;
        return $this;
    }

    /**
     * Set the Domain
     *
     * @throws ApiException
     * @param string $apiDomain
     * @return ApiCreds
     **/
    public function setDomain($apiDomain = null)
    {
        if (is_string($apiDomain) !== true)
        {
            throw new ApiException('API domain must be a string.');
        }

        $this->_userDomain = $apiDomain;
        return $this;
    }

    /**
     * Utility method for checking/validating all credentials (class properties)
     *
     * @throws ApiException
     * @return void
     **/
    private function checkCreds()
    {
        // Username must be set
        if (is_null($this->_userName) === true)
        {
            throw new ApiException('API Username has not been set.');
        }

        // Password must be set
        if (is_null($this->_userPass) === true)
        {
            throw new ApiException('API Password has not been set.');
        }

        // Company must be set
        if (is_null($this->_userCompany) === true)
        {
            throw new ApiException('API Company has not been set.');
        }

        // Domain must be set
        if (is_null($this->_userDomain) === true)
        {
            throw new ApiException('API Domain has not been set.');
        }
    }

    /**
     * Return credentials in an API friendly array
     *
     * @return array
     **/
    public function getCredsArray()
    {
        // Check creds -- exception thrown if there is a problem
        $this->checkCreds();

        // Build an API friendly credentials array
        $this->apiCreds[$this->_userDomain] = $this->_userDomain;
        $this->apiCreds['CompanyId'] = $this->_userCompany;
        $this->apiCreds['IntegratorLoginId'] = $this->_userName;
        $this->apiCreds['IntegratorPassword'] = $this->_userPass;

        return $this->apiCreds;
    }
}
