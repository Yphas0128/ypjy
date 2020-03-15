<?php


    namespace App\Tools;
    use Qcloud\Cos\Api;

    use App\Http\Controllers\Controller;

    class Uploads extends  Controller
    {

        function uploadImg($fileName,$realPath){
            $cosClient = new Qcloud\Cos\Client(array('region' => 'yphas-1301342726',
                'credentials'=> array(
                    'appId' => '	1301342726',
                    'secretId'    =>'AKIDPbYFl9zF0f5GBytrwsiLi3DD5rScsDdr',
                    'secretKey' => 'A7pOq31kHbgV9i38yc2CC0hAuRnvrXyU')));
            try {
                $result = $cosClient->putObject(array(
                    'Bucket' => env('BUCKET'),
                    'Key' =>  $fileName,
                    'Body' => fopen($realPath, 'rb'),
                    'ServerSideEncryption' => 'AES256'));
            } catch (\Exception $e) {
                echo "$e\n";
                echo '</br> 失败';
            }
        }








        //图片上传
        public function adv_upload($data = []){

        }

    }