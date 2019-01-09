<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/6 0006
 * Time: 18:07
 */

namespace Wayee\ImageRecognition;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    /**
     * 在注册后启动服务。
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/baidu.php' => config_path('baidu.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(ImageRecognition::class, function($app){
            return new ImageRecognition($app['config']);
        });

        $this->app->alias(ImageRecognition::class, 'image-recognition');
    }

    public function provides()
    {
        return [ImageRecognition::class, 'image-recognition'];
    }
}