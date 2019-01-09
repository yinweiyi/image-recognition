<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9 0009
 * Time: 9:56
 */

namespace Wayee\ImageRecognition;

use Wayee\ImageRecognition\Exceptions\InvalidArgumentException;

class VehicleLicense extends Base
{

    const URL = 'https://aip.baidubce.com/rest/2.0/ocr/v1/vehicle_license';

    /**
     * 图片识别
     *
     * @param $image
     * @param bool $detectDirection 是否检测图像旋转角度
     * @param string $accuracy normal 使用快速服务，1200ms左右时延；缺省或其它值使用高精度服务，1600ms左右时延
     * @return mixed
     * @throws Exceptions\HttpException
     * @throws InvalidArgumentException
     */
    public function image($image, $detectDirection = true, $accuracy = '')
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
            'detect_direction' => $detectDirection,
            'accuracy' => $accuracy,
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
            $wordsResult = $result['words_result'];
            $response = [
                'brand' => $wordsResult['品牌型号']['words'],
                'issue_date' => $wordsResult['发证日期']['words'],
                'use_type' => $wordsResult['使用性质']['words'],
                'engine_number' => $wordsResult['发动机号码']['words'],
                'number' => $wordsResult['号牌号码']['words'],
                'name' => $wordsResult['所有人']['words'],
                'address' => $wordsResult['住址']['words'],
                'register_date' => $wordsResult['注册日期']['words'],
                'identify_code' => $wordsResult['车辆识别代号']['words'],
                'car_type' => $wordsResult['车辆类型']['words'],
            ];
        }
        return $response;
    }

}