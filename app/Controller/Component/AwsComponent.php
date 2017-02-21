<?php

require 'aws/aws-autoloader.php';

use Aws\S3\S3Client;

class AwsComponent extends Component
{
    /**
     * @var : name of bucket in which we are going to operate
     */
    private $bucket = 'bgsf';

    /**
     * @var : Amazon S3Client object
     */
    private $s3 = null;

    public function __construct()
    {
        $this->s3 = S3Client::factory(array(
            'credentials' => array(
                'key' => '',
                'secret' => '',
            ),
            'region' => 'ap-south-1',
            'version' => 'latest',
            'signature_version' => 'v4',
        ));
    }

    /**
     * @desc : to upload file on bucket with specified path
     *
     * @param : keyname > path of file which need to be uploaded
     *
     * @return : uploaded file object
     * @created on : 14.03.2014
     */
    public function upload($sourceFile, $fileKey, $isPublic = 0)
    {
        try {
            $acl = 'private';
            if ($isPublic != 0) {
                $acl = 'public-read';
            }

            $ext = pathinfo($fileKey, PATHINFO_EXTENSION);
            $contentType = $this->getMimeContentType($ext);
            $this->s3->putObject(array(
                'Bucket' => $this->bucket,
                'Key' => $fileKey,
                'SourceFile' => $sourceFile,
                'ACL' => $acl,
                'ContentType' => $contentType,
                'ContentDisposition' => 'attachment;filename='.$fileKey,
            ));
            $this->s3->waitUntil('ObjectExists', array(
                'Bucket' => $this->bucket,
                'Key' => $fileKey,
            ));

            // Get cdnUrl for uploaded object.
            // $cdnUrl = $this->getObjectUrl($fileKey, $isPublic);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * It gets the private or public url of the file from S3.
     *
     * @param [type] $fileKey  file to be fetched
     * @param [type] $isPublic file is public or private
     *
     * @return [string] S3 url of file
     */
    public function getObjectUrl($fileKey, $isPublic = 0)
    {
        // Object is publicly readable or private
        if ($isPublic == 0) {
            $cmd = $this->s3->getCommand('GetObject', [
                    'Bucket' => $this->bucket,
                    'Key' => $fileKey,
                    'request-content-disposition' => 'attachment;finename='.$fileKey,
                ]);

            $request = $this->s3->createPresignedRequest($cmd, '+20 minutes');
            // Get the actual presigned-url
            $objUrl = (string) $request->getUri();
        } else {
            $objUrl = $this->s3->getObjectUrl($this->bucket, $fileKey);
        }

        return $objUrl;
    }

    /**
     * This function returns mimeContentType.
     *
     * @param string $ext File Extension
     *
     * @return string MIME Content Type
     */
    private function getMimeContentType($ext)
    {
        $contentType = 'application/octet-stream';

        $mimeTypes = array(
            'txt' => 'text/plain',
            'json' => 'application/json',
            'xml' => 'text/xml',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            /*'zip'   => 'application/zip',
            'rar'   => 'application/x-rar-compressed',*/

            // audio/video
            /*'mp3'   => 'audio/mpeg',
            'qt'    => 'video/quicktime',
            'mov'   => 'video/quicktime',*/

            // adobe
            /*'pdf'   => 'application/pdf',
            'psd'   => 'image/vnd.adobe.photoshop',*/

            // ms office
            'doc' => 'application/msword',
            'docx' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower($ext);
        if (isset($mimeTypes[$ext])) {
            $contentType = $mimeTypes[$ext];
        }

        return $contentType;
    }

    /**
     * @desc : to delete multiple objects from bucket
     *
     * @param : array(
     )
     * @return : boolean
     * @created on : 14.03.2014
     */
    public function delete($fileKey)
    {
        try {
            return $this->s3->deleteObject(array(
                'Bucket' => $this->bucket,
                'Key' => $fileKey,
            ));
        } catch (RuntimeException $e) {
            if (Configure::read('debug')) {
                echo 'RuntimeException Exception :'.$e->getMessage();
            }
        } catch (Exception $e) {
            if (Configure::read('debug')) {
                echo 'Exception :'.$e->getMessage();
            }
        }

        return false;
    }

    /**
     * This function for download S3 file Content.
     *
     * @param string $key
     * @param bool   $isPublic
     * @param string $saveAs
     *
     * @return string
     */
    public function downloadFile($key, $isPublic = 0, $saveAs = null)
    {
        $client = $this->getS3Client();

        $filter = array(
            'Bucket' => $this->bucketName,
            'Key' => $key,
        );

        if (!is_null($saveAs)) {
            $filter['SaveAs'] = $saveAs;
        }

        $obj = $client->getObject($filter);

        return $obj['Body'];
    }
}
