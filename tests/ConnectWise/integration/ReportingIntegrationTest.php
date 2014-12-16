<?php namespace LabtechSoftware\ConnectwisePsaSdk;

class ReportingIntegrationTest extends PsaTestCase
{
    protected $configuration;
    protected $factory;
    protected $fixture;

    protected function setUp()
    {
        $this->configuration = parent::setUp();
        $this->factory = new ConnectwiseApiFactory();
        $this->fixture = $this->factory->make('Reporting', $this->configuration);
    }

    public function testGetReports()
    {
        $results = $this->fixture->getReports(false);
        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->GetReportsResult);
        $this->assertInternalType('array', $results->GetReportsResult->Report);
        foreach ($results->GetReportsResult->Report as $report) {
            $this->assertInternalType('string', $report->Name);
            $this->assertInternalType('integer', $report->Id);
            $this->assertInternalType('boolean', $report->IsCustom);
            $this->assertInternalType('boolean', $report->VisibleFlag);
            $this->assertInternalType('boolean', $report->OpenNewWindowFlag);
        }
    }

    public function testGetReportFields()
    {
        $results = $this->fixture->getReportFields('Service');
        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->GetReportFieldsResult);
        $this->assertInternalType('array', $results->GetReportFieldsResult->FieldInfo);
        foreach ($results->GetReportFieldsResult->FieldInfo as $field) {
            $this->assertInternalType('string', $field->Name);
            $this->assertInternalType('string', $field->Type);
            $this->assertInternalType('boolean', $field->IsNullable);
        }
    }

    public function testRunReportCount()
    {
        $results = $this->fixture->runReportCount('Service');
        $this->assertInternalType('object', $results);
        $this->assertInternalType('integer', $results->RunReportCountResult);
    }

    public function testRunReportQuery()
    {
        $results = $this->fixture->runReportQuery('Service', 3, 0, '', '');
        $this->assertInternalType('array', $results);
        foreach ($results as $report) {
            $this->assertInternalType('object', $report);
            $this->assertInternalType('string', $report->TicketNbr);
            $this->assertInternalType('string', $report->owner_level_recid);
            $this->assertInternalType('string', $report->Location);
            $this->assertInternalType('string', $report->billing_unit_recid);
            $this->assertInternalType('string', $report->BusGroup);
            $this->assertInternalType('string', $report->SR_Board_RecID);
            $this->assertInternalType('string', $report->Board_Name);
            $this->assertInternalType('string', $report->Site_Name);
            $this->assertInternalType('string', $report->sr_status_recid);
            $this->assertInternalType('string', $report->Urgency);
            $this->assertInternalType('string', $report->service_location);
            $this->assertInternalType('string', $report->Status_SortOrder);
            $this->assertInternalType('string', $report->status_description);
            $this->assertInternalType('string', $report->Source);
            $this->assertInternalType('string', $report->Closed_Flag);
            $this->assertInternalType('string', $report->ClosedDesc);
            $this->assertInternalType('string', $report->date_closed);
            $this->assertInternalType('string', $report->closed_by);
            $this->assertInternalType('string', $report->Type_RecID);
            $this->assertInternalType('string', $report->ServiceType);
            $this->assertInternalType('string', $report->SubType_RecID);
            $this->assertInternalType('string', $report->ServiceSubType);
            $this->assertInternalType('string', $report->SubTypeItem_RecID);
            $this->assertInternalType('string', $report->ServiceSubTypeItem);
            $this->assertInternalType('string', $report->company_name);
            $this->assertInternalType('string', $report->company_recid);
            $this->assertInternalType('string', $report->contact_name);
            $this->assertInternalType('string', $report->contact_recid);
            $this->assertInternalType('string', $report->Address_Line1);
            $this->assertInternalType('string', $report->Address_Line2);
            $this->assertInternalType('string', $report->City);
            $this->assertInternalType('string', $report->State);
            $this->assertInternalType('string', $report->PostalCode);
            $this->assertInternalType('string', $report->Country);
            $this->assertInternalType('string', $report->Summary);
            $this->assertInternalType('string', $report->Detail_Description);
            $this->assertInternalType('string', $report->Internal_Analysis);
            $this->assertInternalType('string', $report->Resolution);
            $this->assertInternalType('string', $report->AGR_Header_RecID);
            $this->assertInternalType('string', $report->agreement_name);
            $this->assertInternalType('string', $report->team_name);
            $this->assertInternalType('string', $report->Territory);
            $this->assertInternalType('string', $report->territory_recid);
            $this->assertInternalType('string', $report->Territory_Manager);
            $this->assertInternalType('string', $report->date_entered);
            $this->assertInternalType('string', $report->entered_by);
            $this->assertInternalType('string', $report->Approved);
            $this->assertInternalType('string', $report->Last_Update);
            $this->assertInternalType('string', $report->Time_Zone);
            $this->assertInternalType('string', $report->Updated_By);
            $this->assertInternalType('string', $report->Date_Required);
            $this->assertInternalType('string', $report->Hours_Actual);
            $this->assertInternalType('string', $report->Hours_Budget);
            $this->assertInternalType('string', $report->Hours_Scheduled);
            $this->assertInternalType('string', $report->Hours_Billable);
            $this->assertInternalType('string', $report->Hours_NonBillable);
            $this->assertInternalType('string', $report->Hours_Invoiced);
            $this->assertInternalType('string', $report->Hours_Agreement);
            $this->assertInternalType('string', $report->Parent);
            $this->assertInternalType('string', $report->resource_list);
            $this->assertInternalType('string', $report->Assigned_By_RecID);
            $this->assertInternalType('string', $report->Age);
            $this->assertInternalType('string', $report->Date_Resolved_UTC);
            $this->assertInternalType('string', $report->Date_Resplan_UTC);
            $this->assertInternalType('string', $report->Date_Responded_UTC);
            $this->assertInternalType('string', $report->Date_Status_Changed_UTC);
            $this->assertInternalType('string', $report->Escalation_Start_Date_UTC);
            $this->assertInternalType('string', $report->Minutes_Before_Waiting);
            $this->assertInternalType('string', $report->Minutes_Waiting);
            $this->assertInternalType('string', $report->Overall_Start_Date_UTC);
            $this->assertInternalType('string', $report->Previous_SR_Status_RecID);
            $this->assertInternalType('string', $report->Resolved_By);
            $this->assertInternalType('string', $report->Resolved_Minutes);
            $this->assertInternalType('string', $report->Resplan_Minutes);
            $this->assertInternalType('string', $report->Resplan_Skipped_Minutes);
            $this->assertInternalType('string', $report->Responded_By);
            $this->assertInternalType('string', $report->Responded_Minutes);
            $this->assertInternalType('string', $report->Responded_Skipped_Minutes);
            $this->assertInternalType('string', $report->Waiting_Flag);
            $this->assertInternalType('string', $report->Severity);
            $this->assertInternalType('string', $report->SR_Severity_RecID);
            $this->assertInternalType('string', $report->Impact);
            $this->assertInternalType('string', $report->SR_Impact_RecID);
            $this->assertInternalType('string', $report->Opportunity_RecID);
            $this->assertInternalType('string', $report->SR_Service_RecID);
            $this->assertInternalType('string', $report->Date_Entered_UTC);
            $this->assertInternalType('string', $report->Date_Closed_UTC);
        }
    }

    public function testRunReportQueryWithFilters()
    {
        $results = $this->fixture->runReportQueryWithFilters('Service', 3, 0, '', '', ['Last_Update']);
        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->RunReportQueryWithFiltersResult);
        $this->assertInternalType('array', $results->RunReportQueryWithFiltersResult->ResultRow);
        foreach ($results->RunReportQueryWithFiltersResult->ResultRow as $report) {
            $this->assertInternalType('object', $report);
            $this->assertInternalType('object', $report->Value);
            $this->assertNotFalse(strtotime($report->Value->_));
            $this->assertInternalType('string', $report->Value->Name);
            $this->assertInternalType('string', $report->Value->Type);
            $this->assertInternalType('boolean', $report->Value->IsNullable);
            $this->assertInternalType('integer', $report->Number);
        }
    }
}
