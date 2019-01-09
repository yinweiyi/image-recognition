<?php

namespace Wayee\ImageRecognition\Redis;


class Token extends Redis
{

    /**
     * @var string
     */
    protected $name = 'token';

    /**
     * 获取单条记录单个字段
     *
     * @param int $id
     * @param string $field
     * @return string
     */
    public function get($name)
    {
        $key = $this->getKey($name);

        return $this->redis->get($key);
    }

    /**
     * 设置
     *
     * @param $name
     * @param $value
     * @param $expired
     * @return mixed
     */
    public function set($name, $value, $expired = null)
    {
        $key = $this->getKey($name);

        $this->redis->set($key, $value);

        if ($expired) {
            $this->redis->expire($key, $expired);
        }
        return true;
    }


}