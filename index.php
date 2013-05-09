<?php require 'api.php';

##################################################################################################
####################################### API Usage Examples #######################################
##################################################################################################

use ConnectWiseApi\ApiException,
    ConnectWiseApi\Configuration,
    ConnectWiseApi\Contact;

try
{
    /**
     * Contact API Examples
     * @todo Add more examples after finishing contact class
     */

    // $test = Contact::addContactToGroup(2, 20, 'testing'); // Need a valid group id 
    /*
    $test = Contact::addOrUpdateContact(array(
        'FirstName' => 'LTWebDevGuy', 'LastName' => 'Testerino', 'ContactRecID' => 0, 'Id' => 0,
        'BirthDay' => '0001-01-01T00:00:00', 'Married' => false, 'CompanyId' => 'ConnectWise',
        'Children' => false, 'Anniversary' => '0001-01-01T00:00:00', 'PortalSecurityLevel' => 6,
        'DisablePortalLogin' => false, 'Inactive' => false,
        'UnsubscribeFlag' => false, 'LastUpdate' => '2011-06-30T09:35:27.113', 'PersonalAddressFlag' => false,
        'Gender' => 'Male',
    ));
    */
    /*
    $test = Contact::addOrUpdateContactCommunicationItem(201, array(
        'Id' => 0, 'Type' => 'PhoneNumber', 'CommunicationTypeId' => 0, 'Description' => 'Direct'
    ));
    */
    /*
    $test = Contact::addOrUpdateContactNote(201, array(
        'Id' => 0, 'NoteType' => 'Comment', 'NoteText' => 'iRack is for shoes', 'IsFlagged' => false
    ));
    */
    // $test = Contact::getAllContactNotes(201);
    // $test = Contact::findCompanies(10, 0, 'Id', 'ContactRecID = 10');
    // $test = Contact::findContacts(10, 0, 'Id', 'ContactRecID = 6');
    // $test = Contact::getContactCommunicationItem(2, 'PhoneNumber', 'Direct');
    // $test = Contact::getAllCommunicationTypesAndDescriptions();
    // $test = Contact::getContactByRecId(201);


    // ------------------------------------------------------------------------------------

    /**
     * Configuration API Examples
     */
    
    /*
    $test = Configuration::addConfiguration(array(
        'Id' => 99, 'ConfigurationTypeId' => 11, 'ConfigurationType' => 'License', 'StatusId' => 1, 
        'ConfigurationName' => 'PSA Software Test 02', 'CompanyId' => '99'
    ));
    */
    
    /*
    $test = Configuration::addConfigurationType(array(
        'Id' => 99, 'Name' => 'Test Config Type', 'InactiveFlag' => false, 'SystemFlag' => true
    ));
    */
    /*
    $test = Configuration::addOrUpdateConfiguration(array(
        'Id' => 557, 'ConfigurationTypeId' => 11, 'StatusId' => 0, 
        'ConfigurationName' => 'PSA Software Test 02 Updatedson'
    ));
    */
    /*
    $test = Configuration::addOrUpdateConfigurationType(array(
        'Id' => 25, 'Name' => 'Test Config Type', 'InactiveFlag' => false, 'SystemFlag' => true
    ));
    */
    // $test = Configuration::getConfiguration(557);
    // $test = Configuration::loadConfiguration(557);
    // $test = Configuration::getConfigurationType(26);
    // $test = Configuration::loadConfigurationType(26);
    // $test = Configuration::findConfigurations(10, 0, 'StatusId = 1', 'Id');
    // $test = Configuration::findConfigurationTypes(1, 0, 'SystemFlag = false', 'Id');
    // $test = Configuration::findConfigurationsCount();
    /*
    $test = Configuration::updateConfiguration(array(
        'Id' => 556, 'ConfigurationTypeId' => 11, 'StatusId' => 0, 
        'ConfigurationName' => 'LT Devs Test Config Edited'
    ));
    */
    /*
    $test = Configuration::updateConfigurationType(array(
        'Id' => 26, 'Name' => 'Test Config Type', 'InactiveFlag' => false, 'SystemFlag' => true,
        'ConfigurationTypeQuestions' => array('ConfigurationTypeQuestion' => array(
            'Id' => 100, 'FieldType' => 'Currency', 'EntryType' => 'Option',
            'ConfigurationTypeId' => 0, 'SequenceNumber' => 1, 'Question' => 'Wat',
            'RequiredFlag' => true, 'InactiveFlag' => false, 'PossibleResponses' => array(
                'Id' => 100, 'ConfigurationTypeQuestionId' => 100, 'Value' => 'huh', 'DefaultFlag' => false
            )
        ))
    ));
    */
    // $test = Configuration::deleteConfiguration(557);
    // $test = Configuration::deleteConfigurationType(25);
    // $test = Configuration::deleteConfigurationTypeQuestion(99);
    // $test = Configuration::deletePossibleResponse(50);

    // Print test results -- use var_dump() to see boolean values, etc
    echo '<pre>';
    echo print_r($test);
    echo '</pre>';
}
catch (Exception $error)
{
    if ($error instanceof SoapFault)
    {
        echo '<h1>Soap Fault Caught</h1>';
    }
    else
    {
        echo '<h1>'.get_class($error).' Exception Caught</h1>';
    }

    echo '<hr />';
    echo $error->getMessage();
}