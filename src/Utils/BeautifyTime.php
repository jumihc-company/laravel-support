<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Utils;

/**
 * 美化时间
 * @package Jmhc\Support\Utils
 */
class BeautifyTime
{
    /**
     * @var int
     */
    protected $current;

    /**
     * @var int
     */
    protected $time;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $suffixFormat;

    public function __construct(int $time, string $format = 'Y-m-d H:i:s', string $suffixFormat = 'H:i:s')
    {
        $this->current = time();
        $this->time = $time;
        $this->format = $format;
        $this->suffixFormat = $suffixFormat;
    }

    public function run()
    {
        $str = date($this->format, $this->time);
        $diff = $this->current - $this->time;

        if ($diff < 60) {
            $str = '刚刚';
        } elseif ($diff < 3600) { // 小于1小时
            $str = floor($diff / 60) . '分钟前';
        } elseif ($diff < 86400) { // 小于1天
            $str = floor($diff / 3600) . '小时前';
        } elseif ($diff < 259200) { // 小于三天
            if (floor($diff / 86400) == 1) {
                $str = '昨天 ' . date($this->suffixFormat, $this->time);
            } else {
                $str = '前天 ' . date($this->suffixFormat, $this->time);
            }
        }

        return $str;
    }
}
