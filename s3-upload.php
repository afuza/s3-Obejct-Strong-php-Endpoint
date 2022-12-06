<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Ramsey\Uuid\Uuid;




if (isset($_POST['submit'])) {

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

    $myuuid = Uuid::uuid4();
    $key = 'brw-'.$myuuid;
    $bucket = "email-save";
    $ekstensi_diperbolehkan    = array('png', 'jpg', 'jpeg', 'gif');
    $namafile = $_FILES['file']['name'];
    $x = explode('.', $namafile);
    $ekstensi = strtolower(end($x));
    $ukuran    = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];

    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        if ($ukuran < 1044070) {
            move_uploaded_file($file_tmp, 'file/' . $namafile);
            try {
                $result = $s3client->putObject([
                    "Bucket" => $bucket,
                    "Key" => $key,
                    "SourceFile" => 'file/' . $namafile,
                    "ACL" => "public-read",
                ]);
                $en_json = json_encode($result["@metadata"]);
                $de_json = json_decode($en_json, true);
                $code = $de_json["statusCode"];
                if ($code == 200) {
                    $url = $result["ObjectURL"];
                    echo $url;
                    $delpath = 'file/' . $namafile;
                    $hapus = unlink($delpath);
                    if ($hapus) {
                        header("Location: index.php");
                    } else {
                        echo "File gagal dihapus";
                    }
                } else {
                    echo "Error";
                }
            } catch (AwsException $e) {
                echo "Error: {$e->getMessage()}" . PHP_EOL;
            }
        } else {
            echo 'UKURAN FILE TERLALU BESAR';
        }
    }
}
