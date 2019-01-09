<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9 0009
 * Time: 9:56
 */

namespace Wayee\ImageRecognition;

use Wayee\ImageRecognition\Exceptions\InvalidArgumentException;

class IdCard extends Base
{

    const URL = 'https://aip.baidubce.com/rest/2.0/ocr/v1/idcard';

    /**
     * 图片识别
     *
     * @param $image
     * @param string $cardSide front：身份证含照片的一面；back：身份证带国徽的一面
     * @param bool $detectDirection 是否检测图像旋转角度
     * @param bool $detectRisk 是否开启身份证风险类型(身份证复印件、临时身份证、身份证翻拍、修改过的身份证)功能，默认不开启
     * @return mixed
     * @throws Exceptions\HttpException
     * @throws InvalidArgumentException
     */
    public function image($image, $cardSide = 'front', $detectDirection = true, $detectRisk = false)
    {
        if (!in_array($cardSide, ['front', 'back'])) {
            throw new InvalidArgumentException('Invalid cardSide format: ' . $cardSide);
        }
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
            'id_card_side' => $cardSide,
            'detect_risk' => $detectRisk
        );

        $result = $this->postData($url, $data);

        return $result;
    }

    /**
     * 身份证含照片的一面
     *
     * @param $image
     * @param bool $detectDirection
     * @param bool $detectRisk
     * @return array
     * @throws Exceptions\HttpException
     * @throws InvalidArgumentException
     */
    public function front($image, $detectDirection = true, $detectRisk = false)
    {
        $imageResult = $this->image($image, 'front', $detectDirection, $detectRisk);

        if ($imageResult['image_status'] == 'normal') {
            $detail = $imageResult['words_result'];
            $result = [
                'image_status' => $imageResult['image_status'],
                'name' => $detail['姓名']['words'],
                'sex' => $detail['性别']['words'],
                'nation' => $detail['民族']['words'],
                'birthday' => $detail['出生']['words'],
                'id_card' => $detail['公民身份号码']['words'],
                'address' => $detail['住址']['words'],
            ];
        } else {
            $result = [
                'image_status' => $imageResult['image_status'],
                'msg' => '身份证识别失败'
            ];
        }
        return $result;
    }

    /**
     * 身份证含国徽的一面
     *
     * @param $image
     * @param bool $detectDirection
     * @param bool $detectRisk
     * @return array
     * @throws Exceptions\HttpException
     * @throws InvalidArgumentException
     */
    public function back($image, $detectDirection = true, $detectRisk = false)
    {
        $imageResult = $this->image($image, 'back', $detectDirection, $detectRisk);

        if ($imageResult['image_status'] == 'normal') {
            $detail = $imageResult['words_result'];
            $result = [
                'image_status' => $imageResult['image_status'],
                'issue_date' => $detail['签发日期']['words'],
                'issue_authority' => $detail['签发机关']['words'],
                'expire_date' => $detail['失效日期']['words'],
            ];
        } else {
            $result = [
                'image_status' => $imageResult['image_status'],
                'msg' => '身份证识别失败'
            ];
        }
        return $result;
    }


}