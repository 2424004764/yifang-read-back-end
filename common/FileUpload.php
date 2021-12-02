<?php


namespace app\common;

use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\error\ErrorTrain;

require '../vendor/qiniu/php-sdk/autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;


class FileUpload
{
    use ErrorTrain;

    const AccessKey = 'HDiVUsnQU-oFtI2uW3L3lhTgZsCZ704ha9VdvhxI';
    const SecreKey = 'OUf5o-NH4gKMcHNQqXe6JJccRY_GvY2iePgg9w3C';
    const BucketName = '2424004764'; // 空间名
    private $token = '';
    const FilePrefix = 'yifang-read/'; // 文件前缀
    const HTTP_DOMAIN = 'http://cdn.fologde.com/'; // cdn域名

    public function __construct()
    {
        $auth = new Auth(self::AccessKey, self::SecreKey);
        $this->token = $auth->uploadToken(self::BucketName);
    }

    /**
     * 上传本地文件到七牛云oss
     * 调用示例：
     * @see \app\controllers\SiteController::actionUploadFile
     * @param string $localFilePath 本地文件名
     * @param string $filePrefix 文件后缀 是否自定义文件后缀
     * @return bool
     * @throws \Exception
     */
    public function uploadFile($localFilePath, $filePrefix)
    {
        try {
            if (empty($localFilePath) || !is_file($localFilePath)) {
                return self::setAndReturn(ErrorCode::UPLOAD_FILE_ERROR);
            }

            $uploadMgr = new UploadManager();
            // 取文件名后缀
            $prefix = '';
            if (!empty($filePrefix)) {
                $prefix = $filePrefix;
            } else {
                $prefix = substr(strrchr($localFilePath, '.'), 1);
            }
            $remoteFileName = self::FilePrefix . date("y-m-d-H-i-s", time()) . time() . '.' . $prefix;

            list($ret, $err) = $uploadMgr->putFile($this->token, $remoteFileName, $localFilePath);
            if (!empty($err)) {
                // 上传出错了
                return self::setAndReturn(ErrorCode::UPLOAD_FILE_ERROR);
            } else {
                return self::HTTP_DOMAIN . $ret['key'];
            }
        } catch (\Exception $exception) {
            return self::setAndReturn(ErrorCode::UPLOAD_FILE_ERROR, $exception->getMessage());
        }
    }
}