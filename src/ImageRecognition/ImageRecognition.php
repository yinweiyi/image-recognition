<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9 0009
 * Time: 9:56
 */

namespace Wayee\ImageRecognition;

use Illuminate\Config\Repository;
use Wayee\ImageRecognition\Exceptions\Exception;

class ImageRecognition
{

    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function with($name)
    {
        $method = 'create' . ucfirst(camel_case($name)) . 'Driver';

        if (!method_exists($this, $method)) {
            throw new Exception('driver ' . $name . 'not exists');
        }
        return $this->$method();
    }

    /**
     * id Card driver
     *
     * @return IdCard
     */
    public function createIdCardDriver()
    {
        $config = $this->config->get('baidu');
        return new IdCard($config['app_id'], $config['api_key'], $config['secret_key']);
    }
}