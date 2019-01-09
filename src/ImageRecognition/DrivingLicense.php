<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9 0009
 * Time: 9:56
 */

namespace Wayee\ImageRecognition;

use Wayee\ImageRecognition\Exceptions\InvalidArgumentException;

class DrivingLicense extends Base
{

    const URL = 'https://aip.baidubce.com/rest/2.0/ocr/v1/driving_license';

    /**
     * 图片识别
     *
     * @param $image
     * @param bool $detectDirection 是否检测图像旋转角度
     * @param bool $unifiedValidPeriod true: 归一化格式输出；false 或无此参数按非归一化格式输出
     * @return mixed
     * @throws Exceptions\HttpException
     * @throws InvalidArgumentException
     */
    public function image($image, $detectDirection = true, $unifiedValidPeriod = false)
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
            'unified_valid_period' => $unifiedValidPeriod,
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
                'license_no' => $wordsResult['证号']['words'],
                'valid_date' => $wordsResult['有效期限']['words'],
                'car_type' => $wordsResult['准驾车型']['words'],
                'address' => $wordsResult['住址']['words'],
                'until_date' => $wordsResult['至']['words'],
                'name' => $wordsResult['姓名']['words'],
                'country' => $wordsResult['国籍']['words'],
                'birthday' => $wordsResult['出生日期']['words'],
                'sex' => $wordsResult['性别']['words'],
                'first_receive_date' => $wordsResult['初次领证日期']['words'],
            ];
        }
        return $response;
    }

}