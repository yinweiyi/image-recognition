<h1 align="center"> image-recognition </h1>

<p align="center"> 基于 [百度AI开放平台](http://ai.baidu.com/) 的 PHP + Laravel 图片识别组件.</p>


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

## 身份证识别

#### 正面

```shell
$imagePath = 'YOUR_FILE_PATH/front.png';
app('image-recognition')->with('idCard')->front($imagePath)
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
$imagePath = 'YOUR_FILE_PATH/back.png';
app('image-recognition')->with('idCard')->back($imagePath)
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




