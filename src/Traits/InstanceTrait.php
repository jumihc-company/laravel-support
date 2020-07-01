<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Traits;

use Jmhc\Support\Utils\Helper;

/**
 * 单例类 Trait
 * @package Jmhc\Support\Traits
 */
trait InstanceTrait
{
    /**
     * getInstance
     * @param array $params
     * @return static
     */
    public static function getInstance(array $params = [])
    {
        return Helper::instance(get_called_class(), false, $params);
    }
}
