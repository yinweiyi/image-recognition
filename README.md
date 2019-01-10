基于 [百度AI开放平台](http://ai.baidu.com/) 的 PHP+Laravel 图片识别组件.


## 安装

```shell
$ composer require wayee/image-recognition -vvv
```

## 发布配置文件

```shell
 php artisan vendor:publish --provider='Wayee\ImageRecognition\ServiceProvider'
```

#### 在`.env`里面增加
```shell

BAIDU_APP_ID=your APP_ID
BAIDU_API_KEY=your API_KEY
BAIDU_SECRET_KEY=your SECRET_KEY

```

#### 在`config/app.php`的`aliases`数组里面增加
```shell

'ImageRecognition' => \Wayee\ImageRecognition\Facades\ImageRecognition::class

```

## 身份证识别

#### 正面

```shell
use ImageRecognition;

$imagePath = 'YOUR_FILE_PATH/front.png';
ImageRecognition::with('idCard')->front($imagePath);
```

#### 示例：
```shell
    [
        'image_status' => 'normal',
        'name' => '姓名',
        'sex' => '性别',
        'nation' => '民族',
        'birthday' => '出生日期',
        'id_card' => '身份证号码',
        'address' => '住址',
    ]
```

#### 反面

```shell
use ImageRecognition;

$imagePath = 'YOUR_FILE_PATH/back.png';
ImageRecognition::with('idCard')->back($imagePath);
```

#### 示例：
```shell
    [
        'image_status' => 'normal',
        'issue_date' => '签发日期',
        'issue_authority' => '签发机关',
        'expire_date' => '失效日期',
    ]
```

## 银行卡识别

```shell
use ImageRecognition;

$imagePath = 'YOUR_FILE_PATH/bank.png';
ImageRecognition::with('bankCard')->image($imagePath);
```

#### 示例：
```shell
    [
      "bank_card_number" => "4367 4211 4762 0083 682"       //银行卡卡号
      "valid_date" => "NO VALID"                            //有效日期
      "bank_card_type" => 1                                 //银行卡类型，0:不能识别; 1: 借记卡; 2: 信用卡
      "bank_name" => "建设银行"                             //银行名，不能识别时为空
    ]
```

## 驾驶证识别

```shell
use ImageRecognition;

$imagePath = 'YOUR_FILE_PATH/drivingLicense.png';
ImageRecognition::with('DrivingLicense')->image($imagePath);
```

#### 示例：
```shell
    [
      "license_no" => "140105199510033312"                                  //证号
      "valid_date" => "20161104"                                            //有效期限
      "car_type" => "C1"                                                    //准驾车型
      "address" => "山东省太原市大店区白陵告道事处大昊社区西街3号3户"       //住址
      "until_date" => "20221104"                                            //至
      "name" => "张三"                                                      //姓名
      "country" => "中国"                                                   //国籍
      "birthday" => "19920903"                                              //出生日期
      "sex" => "男"                                                         //性别
      "first_receive_date" => "20151104"                                    //初次领证日期
    ]
```

## 行驶证识别

```shell
use ImageRecognition;

$imagePath = 'YOUR_FILE_PATH/vehicle_license.png';
ImageRecognition::with('vehicleLicense')->image($imagePath);
```

#### 示例：
```shell
    [
      "brand" => "奇瑞牌SQR7161A2H"                             //品牌型号
      "issue_date" => "20140423"                                //发证日期
      "use_type" => "非营运"                                    //使用性质
      "engine_number" => "FF6K02921"                            //发动机号码
      "number" => "苏EA61N8"                                    //号牌号码
      "name" => "周颐"                                          //所有人
      "address" => "江苏省苏州市吴江区松陵镇庞南文化新村"       //住址
      "register_date" => "20061218"                             //注册日期
      "identify_code" => "LVVDC11BX6D209011"                    //车辆识别代号
      "car_type" => "小型轿车"                                  //车辆类型
    ]
```
