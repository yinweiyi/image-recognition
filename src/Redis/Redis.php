<?php

namespace Wayee\ImageRecognition\Redis;

use Predis\Client;
use Predis\ClientInterface;
use \Illuminate\Support\Facades\Redis as RedisClient;

class Redis
{
    /**
     * @var ClientInterface|Client
     */
    protected $redis;

    /**
     * 使用的数据库名称
     *
     * @var string
     */
    protected $dbName = 'default';

    /**
     * 缓存名称
     *
     * @var string
     */
    protected $name = 'base';

    /**
     * 命名空间
     *
     * @var string
     */
    private $namespace;

    public function __construct()
    {
        $this->redis = RedisClient::connection($this->dbName);

        $this->namespace = $this->name . ':';
    }

    /**
     * 获取redis存储key
     *
     * @param $key
     * @return string
     */
    protected function getKey($key)
    {
        return $this->namespace . $key;
    }

    /**
     * 日志记录
     *
     * @param string $info
     */
    protected function log($info = '')
    {
        info($info);
    }

}