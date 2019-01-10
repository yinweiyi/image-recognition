<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10 0010
 * Time: 11:21
 */

namespace Wayee\ImageRecognition\Facades;

use Illuminate\Support\Facades\Facade;

class ImageRecognition extends Facade
{
    /**
     * 获取组件的注册名称
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'image-recognition';
    }
}