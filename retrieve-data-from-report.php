<?php

/*
This code demonstrates how to retrieve the data for a specific report and parse it to generate output. 
In this example, we're outputting the report name and the name and type of the first visualization in the report. 
You can modify the code to parse the report data in the way that best suits your needs.
*/

$resource = "https://analysis.windows.net/powerbi/api";
$tenant_id = "<your-tenant-id>";
$client_id = "<your-client-id>";
$client_secret = "<your-client-secret>";
$report_id = "<your-report-id>";
$data_source_name = "<your-data-source-name>";
$table_name = "<your-table-name>";
$dax_query = "<your-dax-query>";

// Obtain an access token
$auth_url = "https://login.microsoftonline.com/$tenant_id/oauth2/token";
$data = array(
    "resource" => $resource,
    "client_id" => $client_id,
    "client_secret" => $client_secret,
    "grant_type" => "client_credentials"
);
$options = array(
    "http" => array(
        "header" => "Content-type: application/x-www-form-urlencoded\r\n",
        "method" => "POST",
        "content" => http_build_query($data),
        "ignore_errors" => true
    )
);
$context = stream_context_create($options);
$response = file_get_contents($auth_url, false, $context);
$token = json_decode($response)->access_token;

// Retrieve the report metadata
$report_url = "https://api.powerbi.com/v1.0/myorg/reports/$report_id";
$options = array(
    "http" => array(
        "header" => "Authorization: Bearer $token\r\n",
        "method" => "GET",
        "ignore_errors" => true
    )
);
$context = stream_context_create($options);
$response = file_get_contents($report_url, false, $context);
$report = json_decode($response);

// Find the data source ID for the specified data source name
$data_source_id = "";
foreach ($report->dataSources as $data_source) {
    if ($data_source->name == $data_source_name) {
        $data_source_id = $data_source->id;
        break;
    }
}

// Retrieve the data source details
$data_source_url = "https://api.powerbi.com/v1.0/myorg/datasets/{$report->datasetId}/datasources/$data_source_id";
$response = file_get_contents($data_source_url, false, $context);
$data_source = json_decode($response);

// Retrieve the table details
$table_url = "https://api.powerbi.com/v1.0/myorg/datasets/{$report->datasetId}/tables/$table_name";
$response = file_get_contents($table_url, false, $context);
$table = json_decode($response);

// Execute the DAX query and retrieve the data
$query_url = "https://api.powerbi.com/v1.0/myorg/datasets/{$report->dataset
