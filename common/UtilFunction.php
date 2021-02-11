<?php
/**
 * 公共方法
 * 全方法静态提供
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/26 0026
 * Time: 21:50
 */

namespace app\common;


class UtilFunction
{

    /**
     * 获取随机字符串
     * @param int $length 随机字符串长度
     * @return string
     */
    public static function getRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    /**
     * 获取域名
     * @return string
     */
    public static function getDomain()
    {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
    }

    /**
     * 往邮箱发送一封邮件
     * @param $toEmail string 要发送的邮箱
     * @param $subject string 标题
     * @param  $content string 内容 HTML格式
     */
    public static function toEmailSend($toEmail, $subject, $content)
    {
        try {
            $from = \Yii::$app->getComponents()['mailer']['transport']['username'];
            $body = $content;
            $mailer = \Yii::$app->mailer->compose();

            $mailer->setFrom($from);
            $mailer->setTo($toEmail);
            $mailer->setSubject($subject);
            $mailer->setHtmlBody($body);
            $mailer->send();
        } catch (\Exception $exception) {
            \Yii::warning("给 {$toEmail} 发送邮箱失败：" . $exception->getMessage());
        }
    }
}