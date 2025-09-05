<?php

namespace App\Http\Controllers\Traits;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Storage;

trait downloadUrtTrait
{
    //generate URL for each file or document stored in firebase
    function generateDownloadUrl($filePath){
        if (!empty($filePath)) {
            // Initialize firebase Storage
            $firebaseCredentialsPath = storage_path(env('FIREBASE_CREDENTIALS_PATH'));

            $storage = new StorageClient([
                'projectId' => 'training-application-707f6',
                'keyFilePath' => $firebaseCredentialsPath,
                'httpOptions' => [
                    'verify' => 'C:\php\php-8.2.29-nts-Win32-vs16-x64\extras\ssl\cacert.pem', // Use CA bundle
                    'timeout' => 60,
                ],
            ]);
            // Get the bucket name from the firebase configuration or replace it with your bucket name
            $bucket = $storage->bucket('training-application-707f6.appspot.com');

            // Generate the signed URL for the file
            $object = $bucket->object($filePath);
            $downloadUrl = $object->signedUrl(now()->addHour());

            return $downloadUrl;
        }

        return null;
    }

}
