<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9 0009
 * Time: 9:56
 */

namespace Wayee\ImageRecognition;

use Wayee\ImageRecognition\Exceptions\InvalidArgumentException;

class BankCard extends Base
{
    const URL = 'https://aip.baidubce.com/rest/2.0/ocr/v1/bankcard';

    /**
     * 图片识别
     *
     * @param $image
     * @return mixed
     * @throws Exceptions\HttpException
     * @throws InvalidArgumentException
     */
    public function image($image)
    {
        if (!file_exists($image)) {
            throw new InvalidArgumentException('File ' . $image . ' is not exists');
        }

        $token = $this->getToken();

        $url = self::URL . '?access_token=' . $token;

        $img = file_get_contents($image);
        $img = base64_encode($img);
        $data = array(
            "image" => $img,
        );

        $result = $this->postData($url, $data);

        return $this->response($result);
    }

    /**
     * 格式化返回数据
     *
     * @param $result
     * @return array
     */
    public function response($result)
    {
        if ($errorCode = array_get($result, 'error_code')) {
            $response = [
                'error_code' => $errorCode,
                'error_msg' => array_get($result, 'error_msg', '')
            ];
        } else {
            $response = $result['result'];
        }
        return $response;
    }


}