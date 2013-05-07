<?php require 'api.php';

// Examples
try
{
    // $get = Api\ConnectWise\Contact::getContactCommunicationItem(2, 'PhoneNumber', 'Direct');
    // $get = Api\ConnectWise\Contact::getAllCommunicationTypesAndDescriptions();
    // $get = Api\ConnectWise\Contact::getContact(2);

    echo '<pre>';
    echo print_r($get);
    echo '</pre>';
}
catch (Exception $error)
{
    echo $error->getMessage();
}