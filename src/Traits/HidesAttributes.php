<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Traits;

use Closure;
use Jmhc\Support\Utils\Helper;

/**
 * 隐藏属性 Trait
 * @package Jmhc\Support\Traits
 */
trait HidesAttributes
{
    /**
     * 隐藏属性
     * @var array
     */
    protected $hidden = [];

    /**
     * 显示属性
     * @var array
     */
    protected $visible = [];

    /**
     * 获取隐藏属性
     * @return array
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * 设置隐藏属性
     * @param  array  $hidden
     * @return $this
     */
    public function setHidden(array $hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * 获取显示属性
     * @return array
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * 设置显示属性
     * @param  array  $visible
     * @return $this
     */
    public function setVisible(array $visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * 创建显示属性
     * @param  array|string|null  $attributes
     * @return $this
     */
    public function makeVisible($attributes)
    {
        $attributes = is_array($attributes) ? $attributes : func_get_args();

        $this->hidden = array_diff($this->hidden, $attributes);

        $this->visible = array_merge($this->visible, $attributes);

        return $this;
    }

    /**
     * 判断创建显示属性
     * @param  bool|Closure  $condition
     * @param  array|string|null  $attributes
     * @return $this
     */
    public function makeVisibleIf($condition, $attributes)
    {
        $condition = $condition instanceof Closure ? $condition($this) : $condition;

        return $condition ? $this->makeVisible($attributes) : $this;
    }

    /**
     * 创建隐藏属性
     * @param  array|string|null  $attributes
     * @return $this
     */
    public function makeHidden($attributes)
    {
        $this->hidden = array_merge(
            $this->hidden, is_array($attributes) ? $attributes : func_get_args()
        );

        return $this;
    }

    /**
     * 判断创建隐藏属性
     * @param  bool|Closure  $condition
     * @param  array|string|null  $attributes
     * @return $this
     */
    public function makeHiddenIf($condition, $attributes)
    {
        $condition = $condition instanceof Closure ? $condition($this) : $condition;

        return ($condition instanceof Closure ? $condition() : $condition) ? $this->makeHidden($attributes) : $this;
    }

    /**
     * 递归隐藏属性
     * @param array $arr
     * @return array
     */
    private function hideAttributeRecursive(array $arr)
    {
        if (Helper::isOneDimensional($arr)) {
            return $this->hideAttribute($arr);
        }

        $results = [];
        foreach ($arr as $v) {
            if (is_array($v)) {
                $results[] = $this->hideAttributeRecursive($v);
            }
        }
        return $results;
    }

    /**
     * 隐藏属性
     * @param array $arr
     * @return array
     */
    private function hideAttribute(array $arr)
    {
        if (count($this->getVisible()) > 0) {
            $arr = array_intersect_key($arr, array_flip($this->getVisible()));
        }

        if (count($this->getHidden()) > 0) {
            $arr = array_diff_key($arr, array_flip($this->getHidden()));
        }

        return $arr;
    }

    public function all()
    {
        return $this->hideAttributeRecursive($this->items);
    }
}
