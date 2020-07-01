<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Traits;

/**
 * 重写 Command 类
 * @package Jmhc\Support\Traits
 */
trait OverwriteCommandTrait
{
    public function option($key = null)
    {
        return $this->getCommandClass(parent::option($key));
    }

    public function argument($key = null)
    {
        return $this->getCommandClass(parent::argument($key));
    }

    /**
     * 获取命令行类名称
     * @param $value
     * @return mixed
     */
    protected function getCommandClass($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        return preg_replace('/\/+/', '\\', trim($value, '/'));
    }
}
