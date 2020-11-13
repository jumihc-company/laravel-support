<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Helper;

use Illuminate\Redis\Connections\Connection;

/**
 * Redis辅助
 * @package Jmhc\Support\Helper
 */
class RedisHelper
{
    /**
     * 扫描匹配的键
     * @param Connection $connection
     * @param string $match
     * @param int $count
     * @param int|null $cursor
     * @return array
     */
    public static function scanKeys(Connection $connection, string $match, int $count = 10, ?int $cursor = null)
    {
        $res = [];

        // 扫描
        [$index, $data] = $connection->scan($cursor, [
            'match' => $match,
            'count' => $count,
        ]);

        // 游标存在
        if (! empty($index)) {
            $res = array_merge($res, static::scanKeys($connection, $match, $count, $index));
        }

        // 数据存在
        if (! empty($data)) {
            $res = array_merge($res, $data);
        }

        return $res;
    }
}
