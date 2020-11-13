<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Utils;

use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\HigherOrderCollectionProxy;
use Jmhc\Support\Traits\HidesAttributesTrait;

/**
 * 集合
 * @package Jmhc\Support\Utils
 */
class Collection extends BaseCollection
{
    use HidesAttributesTrait;

    public function __get($key)
    {
        if (! in_array($key, static::$proxies)) {
            return $this->get($key);
        }

        return new HigherOrderCollectionProxy($this, $key);
    }

    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    public function __isset($name)
    {
        return $this->has($name);
    }

    public function __unset($name)
    {
        $this->offsetUnset($name);
    }
}
