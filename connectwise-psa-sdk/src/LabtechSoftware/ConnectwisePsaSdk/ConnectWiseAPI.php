<?php

namespace LabtechSoftware\ConnectwisePsaSdk;

interface ConnectWiseAPI
{
    public function makeRequest($method, $params);
}
