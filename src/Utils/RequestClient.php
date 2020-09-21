<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Support\Utils;

use GuzzleHttp\Client;
use Jmhc\Support\Traits\InstanceTrait;

/**
 * 请求客户端
 * @package Jmhc\Support\Utils
 */
class RequestClient extends Client
{
    use InstanceTrait;

    /**
     * @var string
     */
    protected $userAgent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36';

    public function __construct(array $config = [])
    {
        $default = [
            'verify' => false,
            'headers' => [
                'User-Agent' => $this->userAgent,
            ],
        ];
        parent::__construct($default + $config);
    }
}
