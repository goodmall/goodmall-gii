yii2-gii-goodmall
===========

> "Giiant is huge!"

**PROJECT IS IN BETA STAGE!**

Note: Major changes from 0.4 to 0.5, see [upgrading](UPGRADING.md) for details.

[![Build Status](https://travis-ci.org/schmunk42/yii2-giiant.svg?branch=master)](https://travis-ci.org/schmunk42/yii2-giiant)

这是啥?
-------------

根据你的表结构 给你生出前端react的整套*crud*功能的文件集合

代码主要学自 *giiant*

参考 
- [organizing-large-react-applications](http://engineering.kapost.com/2016/01/organizing-large-react-applications)
- [organizing-redux-application](https://jaysoo.ca/2016/02/28/organizing-redux-application/)
- [organize-your-ember-app-with-pods](http://cball.me/organize-your-ember-app-with-pods/)

Resources
---------

- [Documentation](docs/README.md)
- [Project Source-Code](https://github.com/schmunk42/yii2-giiant)
- [Packagist](https://packagist.org/packages/schmunk42/yii2-giiant)
- [Yii Extensions](http://www.yiiframework.com/extension/yii2-giiant/)


Features
--------

### Batch command

- `yii batch` creates all models and/or CRUDs for a set of tables sequentially with a single command

### Model generator

- generates separate model classes to customize and base models classes which can be regenerated on schema changes
- table prefixes can be stipped off model class names (not bound to `db` connection settings from Yii 2.0)

### CRUD generator

- input, attribute, column and relation customization with provider queues
- callback provider to inject any kind of code for inputs, attributes and columns via dependency injection
- virtual-relation support (non-foreign key relations)
- model, view and controller locations can be customized to use subfolders
- horizontal and vertical form layout
- options for tidying generated code
- action button class customization (Select "App Class" option on the  Action Button Class option on CRUD generator to customize)


Installation
------------

~~~
    	 "repositories":[
           {
             "type": "path",
             "url": "./year/gii/goodmall",
               "options": {
                   "symlink": true
               }
           }
           ]
          
          require:{
            "year/gii-goodmall": "^1.0.0"           
~~~
注意一旦安装成功 信息会写到yiisoft/extension 的扩展集合中（因为 **"type": "yii2-extension"**,） 如果通过composer卸载了该插件
 有可能需要你手动删除extensions.php下的相关片段！

Configuration
-------------

It's recommended to configure a customized `batch` command in your application CLI configuration.

    'controllerMap' => [
        'batch' => [
            'class' => 'schmunk42\giiant\commands\BatchController',
            'overwrite' => true,
            'modelNamespace' => 'app\\modules\\crud\\models',
            'crudTidyOutput' => true,
        ]
    ],

> Note: `yii giiant-batch` is an alias for the default configuration of `BatchController` registered by this extension.

You can add the giiant specific configuration `config/giiant.php`, and include this from your `config/main.php`.

See the [batches](docs/20-batches.md) section for configuration details.


Usage
-----

To create a full-featured database backend, run the CLI batch command

    yii batch

You can still override the settings from the configuration, like selecting specific tables

    yii batch --tables=a,list,of,tables


### Core commands

 


goodmallnced
--------

### Provider usage and configuration via dependency injection 


### Using callbacks to provide code-snippets

See [docs](docs/31-callback-provider-examples.md) for details.

### Troubleshooting



Extras
------



Screenshots
-----------



在该库下 是可以继承giiant 里面的对应类的 就不用你重头写了 把giiant当**类库**用就对了

Built by [yiqing](http://gitbub.com/yiqing)

##  硬链接

克隆时： git clone -c core.symlinks=true <your-url>

创建链接：

需要admin权限哦

 例子
~~~win-cmd

mklink /D .src  C:"\Program Files\Java"

~~~
在提交时会发生递归提交 
此时先右击目录 用git的add 命令先添加 然后再提交 就可以了

参考： https://github.com/git-for-windows/git/wiki/Symbolic-Links#creating-symbolic-links

咋搞的！