<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Utils;

use DfaFilter\Exceptions\PdsBusinessException;
use DfaFilter\HashMap;

/**
 * 敏感词辅助
 * @package Jmhc\Support\Utils
 */
class SensitiveHelper extends \DfaFilter\SensitiveHelper
{
    protected static $_instance = false;

    public static function init()
    {
        if (! self::$_instance instanceof self) {
            self::$_instance = new static();
        }
        return self::$_instance;
    }

    public function setTree($sensitiveWords = null, bool $isNew = false)
    {
        if (empty($sensitiveWords)) {
            throw new PdsBusinessException('词库不能为空', PdsBusinessException::EMPTY_WORD_POOL);
        }

        $this->wordTree = $isNew ? new HashMap() : ($this->wordTree ?: new HashMap());

        foreach ($sensitiveWords as $word) {
            $this->buildWordToTree($word);
        }
        return $this;
    }
}
