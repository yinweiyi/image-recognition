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

    /**
     * 获取识别类型类
     *
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function with($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();
        $method = 'create' . ucfirst(camel_case($name)) . 'Driver';

        if (!method_exists($this, $method)) {
            throw new Exception('driver ' . $name . 'not exists');
        }
        return $this->$method();
    }

    /**
     * 获取默认驱动器
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'idCard';
    }

    /**
     * 创建身份证识别
     *
     * @return IdCard
     */
    public function createIdCardDriver()
    {
        $config = $this->config->get('baidu');
        return new IdCard($config['app_id'], $config['api_key'], $config['secret_key']);
    }

    /**
     * 创建银行卡识别
     *
     * @return BankCard
     */
    public function createBankCardDriver()
    {
        $config = $this->config->get('baidu');
        return new BankCard($config['app_id'], $config['api_key'], $config['secret_key']);
    }

    /**
     * 创建驾驶证识别
     *
     * @return DrivingLicense
     */
    public function createDrivingLicenseDriver()
    {
        $config = $this->config->get('baidu');
        return new DrivingLicense($config['app_id'], $config['api_key'], $config['secret_key']);
    }

    /**
     * 创建行驶证识别
     *
     * @return VehicleLicense
     */
    public function createVehicleLicenseDriver()
    {
        $config = $this->config->get('baidu');
        return new VehicleLicense($config['app_id'], $config['api_key'], $config['secret_key']);
    }
}