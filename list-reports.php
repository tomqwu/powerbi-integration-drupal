<?php

/*
 Integrating Power BI reports with Drupal is possible by using the Power BI Embedded feature. Here are the high-level steps to do this:

Publish the Power BI report to the Power BI service.
Create an embed token to allow the Drupal site to access the report.
Use the Power BI JavaScript API to embed the report into the Drupal site.
Here are the detailed steps:

Publish the Power BI report to the Power BI service:

Sign in to the Power BI service, and open the report you want to embed.
Click the "File" menu, and then select "Embed" -> "Publish to web".
In the "Publish to web" dialog box, click "Create embed code".
In the "Embed" dialog box, select the options you want for your report, and then click "Create".
Copy the embed code that's generated.
Create an embed token:

Use the Power BI REST API to create an embed token. You'll need to specify the report ID, the permissions you want to grant to the Drupal site, and the expiration date and time for the token.
Save the embed token securely, as it will be used to embed the report in the Drupal site.
Embed the report in the Drupal site:

In the Drupal site, add the Power BI JavaScript API library to the page where you want to embed the report.
Use the Power BI JavaScript API to embed the report, using the embed code and embed token you created earlier.
You can customize the appearance and behavior of the embedded report using the Power BI JavaScript API.
These are the basic steps to integrate a Power BI report with a Drupal site. Keep in mind that this process can be complex, and may require significant technical expertise to complete. If you're not comfortable with the technical aspects of this integration, you may want to consider hiring a developer with experience in integrating Power BI reports with web applications.
Integrating Power BI reports with Drupal is possible by using the Power BI Embedded feature. Here are the high-level steps to do this:

Publish the Power BI report to the Power BI service.
Create an embed token to allow the Drupal site to access the report.
Use the Power BI JavaScript API to embed the report into the Drupal site.
Here are the detailed steps:

Publish the Power BI report to the Power BI service:

Sign in to the Power BI service, and open the report you want to embed.
Click the "File" menu, and then select "Embed" -> "Publish to web".
In the "Publish to web" dialog box, click "Create embed code".
In the "Embed" dialog box, select the options you want for your report, and then click "Create".
Copy the embed code that's generated.
Create an embed token:

Use the Power BI REST API to create an embed token. You'll need to specify the report ID, the permissions you want to grant to the Drupal site, and the expiration date and time for the token.
Save the embed token securely, as it will be used to embed the report in the Drupal site.
Embed the report in the Drupal site:

In the Drupal site, add the Power BI JavaScript API library to the page where you want to embed the report.
Use the Power BI JavaScript API to embed the report, using the embed code and embed token you created earlier.
You can customize the appearance and behavior of the embedded report using the Power BI JavaScript API.

These are the basic steps to integrate a Power BI report with a Drupal site. Keep in mind that this process can be complex, and may require significant technical expertise to complete. If you're not comfortable with the technical aspects of this integration, you may want to consider hiring a developer with experience in integrating Power BI reports with web applications.

This code demonstrates how to obtain an access token and use it to retrieve a list of reports. 
To retrieve the data for a specific report and generate a graph or visualization, 
you'll need to use the Get Report API endpoint and parse the data in PHP to generate the desired output.


*/

$resource = "https://analysis.windows.net/powerbi/api";
$tenant_id = "<your-tenant-id>";
$client_id = "<your-client-id>";
$client_secret = "<your-client-secret>";

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

// Retrieve the list of reports
$reports_url = "https://api.powerbi.com/v1.0/myorg/reports";
$options = array(
    "http" => array(
        "header" => "Authorization: Bearer $token\r\n",
        "method" => "GET",
        "ignore_errors" => true
    )
);
$context = stream_context_create($options);
$response = file_get_contents($reports_url, false, $context);
$reports = json_decode($response);

// Output the list of reports
foreach ($reports->value as $report) {
    echo $report->name . "\n";
}
