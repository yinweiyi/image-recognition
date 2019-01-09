<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9 0009
 * Time: 9:56
 */

namespace Wayee\ImageRecognition;

use GuzzleHttp\Client;
use Wayee\ImageRecognition\Exceptions\HttpException;
use Wayee\ImageRecognition\Redis\Token;

abstract class Base
{
    /**
     * @var string AppId
     */
    protected $appId;

    /**
     * @var string API Key
     */
    protected $apiKey;

    /**
     * @var string Secret Key
     */
    protected $secretKey;

    /**
     * @var array Guzzle Options
     */
    protected $guzzleOptions = [];

    /**
     * token get url
     */
    const GET_TOKEN_URL = 'https://aip.baidubce.com/oauth/2.0/token';


    public function __construct($appId, $apiKey, $secretKey)
    {
        $this->appId = $appId;
        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
    }

    /**
     * 设置guzzle 实例的参数
     *
     * @param array $options
     */
    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    /**
     * 获取httpClient
     *
     * @return Client
     */
    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * 获取数据
     *
     * @param string $url
     * @param string $param
     * @return mixed
     * @throws HttpException
     */
    public function postData($url = '', $param = '')
    {
        try {
            $response = $this->getHttpClient()->post($url, ['form_params' => $param])->getBody()->getContents();

            return json_decode($response, true);

        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     *  get 获取数据
     *
     * @param string $url
     * @param string $param
     * @return mixed
     * @throws HttpException
     */
    public function getData($url = '', $param = '')
    {
        try {
            $response = $this->getHttpClient()->post($url, ['query' => $param])->getBody()->getContents();

            return json_decode($response, true);

        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 获取token
     *
     * @param bool $force 强制获取
     * @return string
     * @throws HttpException
     */
    public function getToken($force = false)
    {
        $tokenRedis = new Token();
        if (!$force && ($token = $tokenRedis->get($this->appId))) {
            return $token;
        }

        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => $this->apiKey,
            'client_secret' => $this->secretKey,
        ];


        $res = $this->getData(self::GET_TOKEN_URL, $this->getPostData($data));

        $token = $res['access_token'];

        $tokenRedis->set($this->appId, $token, $res['expires_in']);

        return $token;

    }

    /**
     * 获取请求数据
     *
     * @param $param
     * @return bool|string
     */
    public function getPostData($param)
    {
        $o = "";
        foreach ($param as $k => $v) {
            $o .= "$k=" . urlencode($v) . "&";
        }
        return substr($o, 0, -1);
    }


}