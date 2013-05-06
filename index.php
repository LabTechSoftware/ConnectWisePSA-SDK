<?php require 'api.php';

// Example usage...
try
{
    foreach (Api\ConnectWise\Reporting::getReports(false) as $report)
    {
        echo $report->Name;
        echo '<hr />';
    }
}
catch (Exception $error)
{
    echo $error->getMessage();
}