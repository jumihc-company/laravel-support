<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Utils;

use Throwable;

/**
 * 日志辅助
 * @package Jmhc\Support\Utils
 */
class LogHelper
{
    /**
     * @var string
     */
    protected static $dir = 'storage/logs/%s';

    /**
     * 调试日志
     * @param string $name
     * @param string $msg
     * @param bool $withRequestMessage
     * @param mixed ...$params
     * @return mixed
     */
    public static function debug(string $name, string $msg, bool $withRequestMessage = false, ...$params)
    {
        // 添加请求消息
        if ($withRequestMessage) {
            $msg = static::requestMessage() . PHP_EOL . $msg;
        }

        return Log::debug($name, $msg, ...$params);
    }

    /**
     * 保存
     * @param string $name
     * @param string $msg
     * @param bool $withRequestMessage
     * @param mixed ...$params
     * @return mixed
     */
    public static function save(string $name, string $msg, bool $withRequestMessage = false, ...$params)
    {
        // 添加请求消息
        if ($withRequestMessage) {
            $msg = static::requestMessage() . PHP_EOL . $msg;
        }

        return Log::save($name, $msg, ...$params);
    }

    /**
     * 异常保存
     * @param string $name
     * @param Throwable $e
     * @param bool $withRequestMessage
     * @return mixed
     */
    public static function throwableSave(string $name, Throwable $e, bool $withRequestMessage = false)
    {
        // 保存消息
        $msg = $e->getMessage() . PHP_EOL . $e->getTraceAsString();

        // 添加请求消息
        if ($withRequestMessage) {
            $msg = static::requestMessage() . PHP_EOL . $msg;
        }

        return Log::save($name, $msg);
    }

    /**
     * 通过路径保存文件
     * @param string $dir
     * @param array $config
     * @return mixed
     */
    public static function dir(string $dir, array $config = [])
    {
        return Log::setConfig(array_merge([
            'path' => sprintf(static::$dir, $dir),
        ], $config));
    }

    /**
     * 请求消息
     * @return string
     */
    public static function requestMessage()
    {
        $request = ContainerHelper::request();
        $data = json_encode($request->all(), JSON_UNESCAPED_UNICODE);
        return <<<EOL
ip : {$request->ip()}
referer : {$request->server('HTTP_REFERER', '-')}
user_agent : {$request->server('HTTP_USER_AGENT', '-')}
url : {$request->fullUrl()}
method : {$request->method()}
data : {$data}
EOL;
    }
}
