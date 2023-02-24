<?php

/*
how to use the Get Report API endpoint in PHP to retrieve data for a specific report:

This code demonstrates how to retrieve the data for a specific report and parse it to generate output. 
In this example, we're outputting the report name and the name and type of the first visualization in the report. 
You can modify the code to parse the report data in the way that best suits your needs.
*/

$resource = "https://analysis.windows.net/powerbi/api";
$tenant_id = "<your-tenant-id>";
$client_id = "<your-client-id>";
$client_secret = "<your-client-secret>";
$report_id = "<your-report-id>";

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

// Retrieve the report data
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

// Parse the report data to generate a graph or visualization
// Example: output the report name and the first visualization in the report
echo "Report Name: " . $report->name . "\n";
$first_visual = $report->visuals[0];
echo "Visual Name: " . $first_visual->name . "\n";
echo "Visual Type: " . $first_visual->type . "\n";
