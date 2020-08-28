## Laravel Blade template for Hyperf

### Install

Via Composer

```
composer require fangx/view
```

### Config

```php
# config/autoload/view.php

return [
    'engine' => \Fangx\View\HyperfViewEngine::class,
    // ...
    # 支持自定义组件
    'components' => [
        // 'alert' => \App\Components\Alert::class
    ],
    
    # 支持设置视图命名空间
    'namespaces' => [
        // 'admin' => __DIR__.'/../view',
    ],
];
```

### Usage

```php
# 1. 支持 hyperf 默认的视图渲染方式
# 2. 提供 view() 函数返回
return view('index');
```