<?php

namespace App\Http\Controllers\crontab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Qcloud\Cos\Client;

class CosController extends Controller{
    protected $crontab;
    protected $user;
    protected $cosClient;
    public function __construct(){
        $secretId = "AKIDPbYFl9zF0f5GBytrwsiLi3DD5rScsDdr"; //"云 API 密钥 SecretId";
        $secretKey = "A7pOq31kHbgV9i38yc2CC0hAuRnvrXyU"; //"云 API 密钥 SecretKey";
        $region = "ap-shanghai"; //设置一个默认的存储桶地域
        $this->cosClient = new Client([
            'region' => $region,
            'schema' => 'https', //协议头部，默认为http
            'credentials' => [
                'secretId' => $secretId,
                'secretKey' => $secretKey
            ]
        ]);
    }
    //上传 图片
    public function add_cos(){
        try {
            $bucket = 'yphas-1301342726'; //存储桶名称
            $key = "/image/1.jpg";//文件在桶中的位置
            $srcPath = "C:/1.jpg";//本地文件绝对路径
            $result = $this->cosClient->putObject(array(
                'Bucket' => $bucket,
                'Key' => $key,
                'Body' => fopen($srcPath, 'rb')));
            } catch (\Exception $e) {
                echo "$e\n";
            }
        }

    public function listObjects(){
        try {
            $bucket = 'yphas-1301342726'; //存储桶名称
            $prefix = ''; // 列出对象的前缀
            $marker = ''; // 上次列出对象的断点
            while (true) {
                $result = $this->cosClient->listObjects([
                    'Bucket' => $bucket,
                    'Marker' => $marker,
                    'MaxKeys' => 1000 // 设置单次查询打印的最大数量，最大为1000
                ]);
                if (isset($result['Contents'])) {
                    foreach ($result['Contents'] as $rt) {
                        echo($rt['Key']);
                    }
                    $marker = $result['NextMarker']; // 设置新的断点
                    if (!$result['IsTruncated']) {
                        break; // 判断是否已经查询完
                    }
                }
            }
        } catch (\Exception $e) {
                echo($e);
            }
        }
}