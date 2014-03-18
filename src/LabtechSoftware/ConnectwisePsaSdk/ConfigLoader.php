<?php


namespace LabtechSoftware\ConnectwisePsaSdk;


class ConfigLoader
{
    private $config = array();

    public function loadConfig()
    {
        foreach (parse_ini_file("config/config.ini", true) as $key => $val) {
            $this->config[$key] = $val;
        }
    }

    public function getSoapOptions()
    {
        return $this->config['soap'];
    }

    public function getSoapAddress($apiName)
    {
        return sprintf($this->config['url']['cw_api_main'], $this->config['credentials']['domain'], $apiName);
    }

    public function getSoapCredentials()
    {
        return $this->config['credentials'];
    }
}
