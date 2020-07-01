<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Utils;

use Illuminate\Support\Collection;

/**
 * 分页
 * @package Jmhc\Support\Utils
 */
class Paginate
{
    /**
     * @var Collection
     */
    protected $list;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $pageSize;

    public function __construct(Collection $list, int $count, int $page, int $pageSize)
    {
        $this->list = $list;
        $this->count = $count;
        $this->page = $page;
        $this->pageSize = $pageSize;
    }

    /**
     * 返回数据
     * @return Collection
     */
    public function get()
    {
        return new Collection([
            'list' => $this->list,
            'count' => $this->count,
            'current_page' => $this->page,
            'page_size' => $this->pageSize,
            'total_page' => ceil($this->count / $this->pageSize),
        ]);
    }
}
