## Laravel Blade template for Hyperf

### Install

Via Composer

```
composer require fangx/view
```

### Config

生成配置文件, **该命令会覆盖 `config/autoload/view.php` 文件**

```
php bin/hyperf.php fangx:view
```

> 该命令会自动发布 `hyperf/session` / `hyperf/validation` / `hyperf/translation` 三个组件的配置文件, 
> 如需覆盖已存在的配置, 请添加 `-f` 参数

内容如下:

```php
<?php

return [
    'engine' => \Fangx\View\HyperfViewEngine::class,
    'mode' => \Hyperf\View\Mode::SYNC,
    'config' => [
        'view_path' => BASE_PATH . '/storage/view/',
        'cache_path' => BASE_PATH . '/runtime/view/',
    ],

    # 自定义组件 @doc https://learnku.com/docs/laravel/7.x/blade/7470#components
    'components' => [
        // 'alert' => \App\View\Components\Alert::class,
    ],

    # 视图命名空间 (通常用于扩展包中)
    'namespaces' => [
        // 'admin' => BASE_PATH . '/storage/view/vendor/admin',
    ],
];

```

### Usage

- 添加中间件

```php
# config/autoload/middlewares.php
return [
    'http' => [
        // ...others
        \Hyperf\Session\Middleware\SessionMiddleware::class, # session
        \Hyperf\Validation\Middleware\ValidationMiddleware::class, # validation
        \Fangx\View\Http\Middleware\ShareErrorsFromSession::class, # 将 session 中的 errors 共享给视图
        \Fangx\View\Http\Middleware\ValidationExceptionHandle::class, # 自动捕捉 validation 中的异常加入到 session 中
    ],
];
```

```php
# 1. 支持 hyperf 默认的视图渲染方式
# 2. 提供 view() 函数返回
return view('index');
```