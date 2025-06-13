<?php
/**
 * Download data from the eCFR API
 */

 require_once 'lib/ThrowableErrors.php';

// Define the base URL for the API
$baseURL = 'https://www.ecfr.gov/api';

// Define the base URL for the admin API
$adminServiceApi = $baseURL . '/admin/v1';
// Define the base URL for the versioner service API
$versionerServiceApi = $baseURL . '/versioner/v1';


// Store Raw JSON data to file
$dataDirectory = dirname(__FILE__) . '/data';


try {
    // Fetch and save agencies data
    saveDataToFile($dataDirectory . '/agencies.json', getAgenciesFromAdminSerivceApi($adminServiceApi));
    echo "Agencies data saved successfully.\n";
    // Fetch and save titles summaries data
    saveDataToFile($dataDirectory . '/titles_summaries.json', getTitlesSummariesFromVersionerServiceApi($versionerServiceApi));
    echo "Titles summaries data saved successfully.\n";
} catch (Throwable $e) {
    echo 'An error occurred: ' . $e->getMessage();
    exit(1);
}

function saveDataToFile($filePath, $data)
{
    if (file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT)) === false) {
        ThrowableErrors::dataStorageError('Failed to write data to file: ' . $filePath);
    }
}

function getAgenciesFromAdminSerivceApi($adminServiceApi)
{
    $url = $adminServiceApi . '/agencies.json';

    return getApiData(url: $url);
}

function getTitlesSummariesFromVersionerServiceApi($versionerServiceApi)
{
    $url = $versionerServiceApi . '/versions.json';

    return getApiData(url: $url);
}

function getTitlesFromVersionerServiceApi($versionerServiceApi, $title)
{
    // Validate title input
    if (empty($title) || !is_string($title)) {
        ThrowableErrors::apiRequestError('Title must be a non-empty string.');
    }
    $url = $versionerServiceApi . 'versions/title-{title}.json';

    return getApiData(url: $url);
}

function getApiData($url)
{
    $response = file_get_contents($url);

    if ($response === FALSE) {
      ThrowableErrors::apiRequestError('Failed to fetch data from API: ' . $url);
    }

    if (empty($response)) {
        ThrowableErrors::apiResponseError('Received empty response from API: ' . $url);
    }

    $data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Error decoding JSON response: ' . json_last_error_msg());
    }
    
    return $data;
}