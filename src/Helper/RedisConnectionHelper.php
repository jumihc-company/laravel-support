<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Helper;

use Illuminate\Redis\Connections\Connection;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

/**
 * Redis链接辅助
 * @package Jmhc\Support\Helper
 */
class RedisConnectionHelper
{
    /**
     * 获取默认 redis 操作句柄
     * @return Connection
     */
    public static function get()
    {
        return Redis::connection();
    }

    /**
     * 获取默认无前缀 redis 操作句柄
     * @return Connection
     */
    public static function getNoPrefix()
    {
        $id = 'redis.no.prefix';

        if (! app()->has($id)) {
            $config = config('database.redis', []);
            $config['options']['prefix'] = '';

            $redis = new RedisManager(
                app('app'),
                Arr::pull($config, 'client', 'phpredis'),
                $config
            );
            app()->instance($id, $redis->connection());
        }

        return app()->get($id);
    }

    /**
     * 获取 phpredis 驱动的操作句柄
     * @return PhpRedisConnection
     */
    public static function getPhpRedis()
    {
        $id = 'php.redis';

        if (! app()->has($id)) {
            $redis = new RedisManager(
                app('app'),
                'phpredis',
                config('database.redis', [])
            );
            app()->instance($id, $redis->connection());
        }

        return app()->get($id);
    }

    /**
     * 获取无前缀 phpredis 驱动的操作句柄
     * @return PhpRedisConnection
     */
    public static function getPhpRedisNoPrefix()
    {
        $id = 'php.redis.no.prefix';

        if (! app()->has($id)) {
            $config = config('database.redis', []);
            $config['options']['prefix'] = '';

            $redis = new RedisManager(
                app()->make('app'),
                'phpredis',
                $config
            );
            app()->instance($id, $redis->connection());
        }

        return app()->get($id);
    }
}
