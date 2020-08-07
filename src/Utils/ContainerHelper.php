<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Utils;

use Closure;
use Illuminate\Container\Container;

/**
 * 容器辅助
 * @package Jmhc\Support\Utils
 */
class ContainerHelper
{
    /**
     * 获取可用容器实例
     * @param null $abstract
     * @param array $parameters
     * @return Container|mixed|object
     */
    public static function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($abstract, $parameters);
    }

    /**
     * 获取配置容器实例
     * @param null $key
     * @param null $default
     * @return Container|mixed|object
     */
    public static function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return static::app('config');
        }

        if (is_array($key)) {
            return static::app('config')->set($key);
        }

        return static::app('config')->get($key, $default);
    }

    /**
     * 获取请求实例
     * @param null $key
     * @param null $default
     * @return Container|mixed|object|null
     */
    public static function request($key = null, $default = null)
    {
        if (is_null($key)) {
            return static::app('request');
        }

        if (is_array($key)) {
            return static::app('request')->only($key);
        }

        $value = static::app('request')->__get($key);

        return is_null($value) ? ($default instanceof Closure ? $default() : $default) : $value;
    }

    /**
     * 基础路径
     * @param string $path
     * @return mixed
     */
    public static function basePath($path = '')
    {
        return static::app()->basePath($path);
    }
}
