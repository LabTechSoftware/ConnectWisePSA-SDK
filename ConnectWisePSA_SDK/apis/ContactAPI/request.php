<?php namespace ConnectWisePSA;


class ContactAPI_FindContactsRequest extends ConnectWisePSARequest
{
    public function __construct()
    {
        $this->conditions = "";
    }
}