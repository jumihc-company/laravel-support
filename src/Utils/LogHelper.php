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
     * 异常保存
     * @param string $name
     * @param Throwable $e
     * @return mixed
     */
    public static function throwableSave(string $name, Throwable $e)
    {
        return Log::save(
            $name,
            static::requestMessage() . PHP_EOL . $e->getMessage() . PHP_EOL . $e->getTraceAsString()
        );
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
     * 请求信息
     * @return string
     */
    public static function requestMessage()
    {
        $request = ContainerHelper::request();
        return <<<EOL
ip: {$request->ip()}
url: {$request->fullUrl()}
method: {$request->method()}
EOL;
    }
}
