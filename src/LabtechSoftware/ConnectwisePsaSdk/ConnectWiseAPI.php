<?php

namespace LabtechSoftware\ConnectwisePsaSdk;

interface ConnectWiseApi
{
    public function makeRequest($method, $params);
}
