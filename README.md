<h1 align="center"> image-recognition </h1>

<p align="center"> 基于 [百度AI开放平台](http://ai.baidu.com/) 的 PHP 图片识别组件.</p>


## 安装

```shell
$ composer require wayee/image-recognition -vvv
```
## 发布配置文件

```shell
 php artisan vendor:publish --provider='Wayee\ImageRecognition\ServiceProvider'
```

## 配置

在使用本扩展之前，你需要去 [百度AI开放平台](http://ai.baidu.com/) 注册账号，然后创建应用，在`config/baidu.php`里面配置：

```shell
return [
    'app_id' => env('BAIDU_APP_ID', ''),
    'api_key' => env('BAIDU_API_KEY', ''),
    'secret_key' => env('BAIDU_SECRET_KEY', '')
];
```
在`.env`里面增加
```shell

BAIDU_APP_ID=your APP_ID
BAIDU_API_KEY=your API_KEY
BAIDU_SECRET_KEY=your SECRET_KEY

```



