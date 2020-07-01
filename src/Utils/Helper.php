<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Utils;

use Exception;
use Illuminate\Container\Container;
use Illuminate\Support\Arr;
use Illuminate\Support\Env;

/**
 * 辅助
 * @package Jmhc\Support\Utils
 */
class Helper
{
    private static $sensitiveReadFile = false;

    /**
     * 获取url地址
     * @param $url
     * @param $value
     * @return string
     */
    protected static function getUrl($url, $value)
    {
        if (empty($value)) {
            return '';
        } elseif (preg_match('/^(http|https)/', $value)) {
            return $value;
        }

        return rtrim($url, '/') . '/' . ltrim($value, '/');
    }

    /**
     * 获取源路径
     * @param $url
     * @param $value
     * @return string
     */
    protected static function getOriginPath($url, $value)
    {
        return str_replace($url, '', $value);
    }

    /**
     * 转换成布尔值
     * @param $value
     * @return bool
     */
    public static function boolean($value)
    {
        if (is_bool($value)) {
            return $value;
        } elseif ($value === 'true') {
            return true;
        } elseif ($value === 'false') {
            return false;
        }

        return !!$value;
    }

    /**
     * 数值转金钱
     * @param $value
     * @return float
     */
    public static function int2money($value)
    {
        return round($value / 100, 2);
    }

    /**
     * 金钱转数值
     * @param $value
     * @return int
     */
    public static function money2int($value)
    {
        return intval($value * 100);
    }

    /**
     * 处理提示数量
     * @param int $num
     * @param int $max
     * @param int $min
     * @return string
     */
    public static function handleNoticeNum(int $num, int $max = 99, int $min = 0)
    {
        return (string) ($num > $max ? $max . '+' : (($num > $min) ? $num : $min));
    }

    /**
     * 获取随机数
     * @param int $len
     * @return string
     * @throws Exception
     */
    public static function getRandomStr(int $len = 12)
    {
        return bin2hex(random_bytes(floor($len / 2)));
    }

    /**
     * 格式化时间
     * @param int $time
     * @param string $format
     * @param string $suffixFormat
     * @return string
     */
    public static function beautifyTime(int $time, string $format = 'Y-m-d H:i:s', string $suffixFormat = 'H:i:s')
    {
        return (new BeautifyTime($time, $format, $suffixFormat))->run();
    }

    /**
     * 数组转换成key
     * @param array $arr
     * @param string $flag
     * @return string
     */
    public static function array2key(array $arr, string $flag = '')
    {
        return md5(json_encode(Arr::sortRecursive($arr)) . $flag);
    }

    /**
     * 字符串转数组
     * @param string $str "['a' => 1]"
     * @return array ['a' => 1]
     */
    public static function str2array(string $str)
    {
        $str = str_replace([' ', "\n", "\r\n", '[', ']'], '', $str);
        $arr = [];
        foreach (explode(',', $str) as $v) {
            // 不存在值忽略
            if ($v == '') {
                continue;
            }

            // 处理值
            $_replace = str_replace(['"', "'"], '', $v);
            if (in_array($v, ['true', 'false'])) {
                $v = static::boolean($v);
            } elseif ($v === 'null') {
                $v = null;
            } elseif ($_replace !== $v) {
                $v = $_replace;
            } else {
                $v = (int) $v;
            }

            // 直接添加
            if (strpos($v, '=>') === false) {
                array_push($arr, $v);
                continue;
            }

            // 带键值的添加
            $_arr = explode('=>', $v);
            if (isset($_arr[0]) && isset($_arr[1])) {
                $arr[str_replace(['"', "'"], '', $_arr[0])] = $_arr[1];
            }
        }
        return $arr;
    }

    /**
     * 单例辅助
     * @param string $class
     * @param bool $refresh
     * @param array $params
     * @return mixed
     */
    public static function instance(string $class, bool $refresh = false, array $params = [])
    {
        $id = static::array2key($params, $class);
        if (!Container::getInstance()->has($id) || $refresh) {
            Container::getInstance()->instance($id, Container::getInstance()->make($class, $params));
        }

        return Container::getInstance()->get($id);
    }

    /**
     * 获取测试环境变量
     * @param string $test
     * @param string $product
     * @param null $default
     * @return mixed
     */
    public static function getTestEnv(string $test, string $product, $default = null)
    {
        $res = Env::get($test);

        if (!$res) {
            $res = Env::get($product, $default);
        }

        return $res;
    }

    /**
     * 敏感词类
     * @return SensitiveHelper
     */
    public static function sensitive()
    {
        $handler = SensitiveHelper::init();

        // 防止重复写入
        if (static::$sensitiveReadFile) {
            return $handler;
        }

        // 从文件写入敏感词
        foreach (glob(__DIR__ . '/../../sensitives/*.txt') as $file) {
            $handler->setTreeByFile($file);
        }
        static::$sensitiveReadFile = true;

        return $handler;
    }
}
