<?php

namespace year\gii\goodmall;

use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * Class Bootstrap.
 *
 * @author yiqing <yiqing_95@qq.com>
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @var string
     */
    public $giiBaseUrl = '';
    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        if ($app->hasModule('gii')) {

            // register translations
            if (!isset($app->get('i18n')->translations['goodmall*'])) {
                $app->get('i18n')->translations['goodmall*'] = [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => __DIR__ . '/messages',
                    // 'sourceLanguage' => 'zh-CN',
                ];
            }

            if (!isset($app->getModule('gii')->generators['giiant-goodmall-pod'])) {
                $app->getModule('gii')->generators['gii-goodmall-pod'] = 'year\gii\goodmall\generators\pod\Generator';
            }

            $gk =     'giiant-goodmall-model' ;
            if (!isset($app->getModule('gii')->generators[$gk])) {
                $app->getModule('gii')->generators[$gk] = 'year\gii\goodmall\generators\model\Generator';
            }

            $gk =     'giiant-goodmall-repo' ;
            if (!isset($app->getModule('gii')->generators[$gk])) {
                $app->getModule('gii')->generators[$gk] = 'year\gii\goodmall\generators\repository\Generator';
            }


            $gk =     'giiant-goodmall-crud' ;
            if (!isset($app->getModule('gii')->generators[$gk])) {
                $app->getModule('gii')->generators[$gk] = 'year\gii\goodmall\generators\crud\Generator';
            }

            $gk =     'giiant-goodmall-apis' ;
            if (!isset($app->getModule('gii')->generators[$gk])) {
                $app->getModule('gii')->generators[$gk] = [
                    'class'=>'year\gii\goodmall\generators\api\Generator',
                    // 配置针对其他框架的模板
                    'templates'=>[
                        'echo'=>__DIR__.'/generators/api/echo' ,
                    ],
                 ] ;
            }

            if ($app instanceof \yii\console\Application) {
                $app->controllerMap['giigoodmall-batch'] = 'year\gii\goodmall\commands\BatchController';
            }
        }

        // 注入参数
        if(!empty($this->giiBaseUrl)){
            $app->params['goodmall.giiBaseUrl'] = $this->giiBaseUrl ;
           // die($this->giiBaseUrl) ;
        }

    }
}
