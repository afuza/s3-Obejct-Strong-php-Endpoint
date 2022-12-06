<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$key = $_GET['key'];

$profile_credentials = [
    'endpoint' => 'https://s3.nl-ams.scw.cloud',
    'region' => 'nl-ams',
    'version' => 'latest',
    'use_path_style_endpoint' => true,
    'credentials' => array(
        'key'    => 'YOUR_KEY',
        'secret' => 'your_secret_key',
    ),
];

$bucket = "your_bucket_name";

$s3client = new S3Client($profile_credentials);

try {
    $result = $s3client->deleteObject([
        "Bucket" => $bucket,
        "Key" => $key,
    ]);
    echo "Success: ";
    $en_json = json_encode($result["@metadata"]);
    $de_json = json_decode($en_json, true);
    $code = $de_json["statusCode"];
    if ($code == 204) {
        header("Location: index.php");
    } else {
        echo "Error";
    }
} catch (AwsException $e) {
    echo "Error: {$e->getMessage()}" . PHP_EOL;
}