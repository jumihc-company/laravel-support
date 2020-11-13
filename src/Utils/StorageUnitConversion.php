<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Utils;

use InvalidArgumentException;

/**
 * 储存单位转换
 * @package Jmhc\Support\Utils
 */
class StorageUnitConversion
{
    /**
     * @var string
     */
    protected static $pattern = '/^(\d+\.?\d*)([a-z]+)$/';

    /**
     * @var string
     */
    protected static $units = 'bkmgtpezybnd';

    /**
     * @var string[]
     */
    protected static $unitArr = ['b', 'kb', 'mb', 'gb', 'tb', 'pb', 'eb', 'zb', 'yb', 'bb', 'nb', 'db'];

    /**
     * 字符串转字节
     * @param string $str
     * @return float|int|string
     */
    public static function str2byte(string $str)
    {
        // 数字直接返回
        if ($str === '0' || filter_var($str, FILTER_VALIDATE_INT)) {
            return $str;
        }

        preg_match(static::$pattern, mb_strtolower($str), $match);
        if (count($match) != 3) {
            throw new InvalidArgumentException('size format is not correct');
        }

        [, $num, $unit] = $match;
        $pos = stripos(static::$units, $unit);
        if ($pos === false) {
            $pos = array_search($unit, static::$unitArr);
        }

        if ($pos === false) {
            throw new InvalidArgumentException('size unit is incorrect');
        }

        return $num * pow(1024, $pos);
    }
}
