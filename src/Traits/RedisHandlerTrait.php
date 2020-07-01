<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Traits;

use Illuminate\Redis\Connections\Connection;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use Jmhc\Support\Utils\ContainerHelper;

/**
 * Redis 操作句柄 Trait
 * @package Jmhc\Support\Traits
 */
trait RedisHandlerTrait
{
    /**
     * getRedisHandler
     * @return Connection
     */
    protected function getRedisHandler()
    {
        return Redis::connection();
    }

    /**
     * 获取无前缀 redis 操作句柄
     * @return Connection
     */
    protected function getNoPrefixRedisHandler()
    {
        $id = 'redis.no.prefix';

        if (! ContainerHelper::app()->has($id)) {
            $config = ContainerHelper::config('database.redis', []);
            $config['options']['prefix'] = '';

            $redis = new RedisManager(
                ContainerHelper::app('app'),
                Arr::pull($config, 'client', 'phpredis'),
                $config
            );
            ContainerHelper::app()->instance($id, $redis->connection());
        }

        return ContainerHelper::app()->get($id);
    }

    /**
     * 获取 phpredis 驱动的操作句柄
     * @return Connection|\Redis
     */
    public function getPhpRedisHandler()
    {
        $id = 'php.redis';

        if (! ContainerHelper::app()->has($id)) {
            $redis = new RedisManager(
                ContainerHelper::app('app'),
                'phpredis',
                ContainerHelper::config('database.redis', [])
            );
            ContainerHelper::app()->instance($id, $redis->connection());
        }

        return ContainerHelper::app()->get($id);
    }

    /**
     * 获取无前缀 phpredis 驱动的操作句柄
     * @return Connection|\Redis
     */
    public function getNoPrefixPhpRedisHandler()
    {
        $id = 'php.redis.no.prefix';

        if (! ContainerHelper::app()->has($id)) {
            $config = ContainerHelper::config('database.redis', []);
            $config['options']['prefix'] = '';

            $redis = new RedisManager(
                ContainerHelper::app()->make('app'),
                'phpredis',
                $config
            );
            ContainerHelper::app()->instance($id, $redis->connection());
        }

        return ContainerHelper::app()->get($id);
    }
}
