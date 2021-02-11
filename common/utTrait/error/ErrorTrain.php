<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/10/24 0024
 * Time: 22:43
 */

/**
 * todo 只能用该trait声明错误
 */

namespace app\common\utTrait\error;
trait ErrorTrain
{
    /**
     * @param string $errCode 错误码
     * @param string $errMessage 重写提示信息，用于直接返回前端信息
     * @param string $logMessage 日志信息
     * @return bool
     */
    public static function setAndReturn($errCode, $errMessage = '', $logMessage = '')
    {
        ErrorInfo::setAndReturn($errCode, $errMessage, $logMessage);
        return false;
    }

    public static function getErrCode()
    {
        $errCode = ErrorInfo::getErrCode();
        if (empty($errCode)) {
            $errCode = ErrorCode::SUCCESS;
        }

        return $errCode;
    }

    public static function getErrMsg()
    {
        return ErrorInfo::getErrMsg();
    }

    public static function getLogMsg()
    {
        return ErrorInfo::getLogMsg();
    }

    public function getAllFirstErrorMessage()
    {
        if (empty($this->firstErrors)) {
            return '';
        }
        return implode(';', $this->firstErrors);
    }

    public static function cleanErrorInfo()
    {
        ErrorInfo::cleanErrorInfo();
    }

    /**
     * 判断 是否上一层返回的 错误情况
     * @param null $result
     * @return bool
     */
    public static function isErrRes($result = null)
    {
        if ($result === null) {
            $bool = self::getErrCode() != ErrorCode::SUCCESS;
        } else {
            $bool = $result === false || self::getErrCode() != ErrorCode::SUCCESS;
        }
        return $bool;
    }

    /**
     * 检查是否 错误情况，然后 抛出异常类
     * @param null $result
     * @throws \Exception
     */
    public static function thrErrRes($result = null)
    {
        if (self::isErrRes($result)) {
            throw new \Exception(self::getErrMsg(), self::getErrCode());
        }
    }

    /**
     * 自定义 错误情况，然后 抛出异常类
     * @param integer|string $errItem 错误消息 | 错误代码
     *      - self::thrErrMsg('请勿频繁操作');
     *      - self::thrErrMsg(ErrorCode::ERR_API_FREQUENT_REQUESTS);
     * @throws \Exception
     */
    public static function thrErrMsg($errItem)
    {
        if (is_numeric($errItem)) {
            throw new \Exception(ErrorMsg::getErrMsg($errItem), $errItem);
        } else {
            throw new \Exception($errItem, ErrorCode::FAILURE);
        }
    }

    /**
     * 获取 异常类 对应的 错误代码
     * @param \Exception $e
     * @return integer|string
     */
    public static function getExpCode(\Exception $e)
    {
        $code = $e->getCode() === 0 ? ErrorCode::FAILURE : $e->getCode();
        return $code;
    }

    /**
     * 获取 异常类 错误代码 对应的 错误消息
     * @param \Exception $e
     * @return string
     */
    public static function getExpMsg(\Exception $e)
    {
        $msg = $e->getMessage();
        if (empty($msg)) {
            $code = self::getExpCode($e);
            $msg = ErrorMsg::getErrMsg($code);
        }
        return $msg;
    }
}