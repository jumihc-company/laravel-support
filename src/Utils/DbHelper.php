<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Utils;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder;
use Jmhc\Support\Traits\InstanceTrait;
use Throwable;

/**
 * 数据库辅助
 * @package Jmhc\Support\Utils
 */
class DbHelper
{
    use InstanceTrait;

    /**
     * 链接
     * @var Connection
     */
    protected $connection;

    /**
     * 架构生成器
     * @var Builder
     */
    protected $schemaBuilder;

    /**
     * 数据表前缀
     * @var string
     */
    protected $prefix;

    public function __construct(string $name = null)
    {
        $this->connection = ContainerHelper::app('db')->connection($name ?: 'mysql');
        $this->schemaBuilder = $this->connection->getSchemaBuilder();
        $this->prefix = $this->connection->getTablePrefix();
    }

    /**
     * 修改表注释
     * @param string $table
     * @param string $comment
     * @return bool
     */
    public function comment(string $table, string $comment)
    {
        try {
            // 判断是否存在前缀
            if ($this->prefix && strpos($table, $this->prefix) !== 0) {
                $table = $this->prefix . $table;
            }

            // 设置备注
            $res = $this->connection->statement(sprintf('ALTER TABLE `%s` COMMENT = "%s"', $table, $comment));

            return !! $res;
        } catch (Throwable $e) {}

        return false;
    }

    /**
     * 获取所有表
     * @param bool $isPrefix
     * @return array
     */
    public function getAllTables(bool $isPrefix = true)
    {
        try {
            return array_map(function ($v) use ($isPrefix) {
                return $isPrefix ? reset($v) : str_replace(
                    $this->prefix,
                    '',
                    reset($v)
                );
            }, $this->schemaBuilder->getAllTables());
        } catch (Throwable $e) {}

        return [];
    }

    /**
     * 获取所有字段
     * @param string $table
     * @return array
     */
    public function getAllColumns(string $table)
    {
        try {
            // 判断是否存在前缀
            if ($this->prefix && strpos($table, $this->prefix) !== 0) {
                $table = $this->prefix . $table;
            }

            // 字段数据
            $data = $this->connection->select('select `column_name`, `data_type`, `column_comment` from information_schema.columns where `table_schema` = ? and `table_name` = ?', [$this->connection->getDatabaseName(), $table]);

            return array_map(function ($v) {
                return array_change_key_case(
                    json_decode(json_encode($v), true),
                    CASE_LOWER
                );
            }, $data);
        } catch (Throwable $e) {}

        return [];
    }

    /**
     * 获取前缀
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
}
