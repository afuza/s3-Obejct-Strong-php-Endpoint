<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

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

$s3client = new S3Client($profile_credentials);

$bucket = "YoutrBucketName";

try {
    $result = $s3client->listObjects([
        "Bucket" => $bucket,
    ]);

    $en_json = json_encode($result["Contents"]);
  
  echo $en_json;
} catch (AwsException $e) {
    echo "Error: {$e->getMessage()}" . PHP_EOL;
}