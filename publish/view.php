<?php

declare(strict_types=1);

/**
 * Fangx's Packages
 *
 * @link     https://nfangxu.com
 * @document https://pkg.nfangxu.com
 * @contact  nfangxu@gmail.com
 * @author   nfangxu
 * @license  https://pkg.nfangxu.com/license
 */

return [
    'engine' => \Fangx\View\HyperfViewEngine::class,
    'mode' => \Hyperf\View\Mode::SYNC,
    'config' => [
        'view_path' => BASE_PATH . '/storage/view/',
        'cache_path' => BASE_PATH . '/runtime/view/',
    ],

    # 自定义组件
    'components' => [
        // 'alert' => \App\Components\Alert::class
    ],

    # 视图命名空间 (用于扩展包中)
    'namespaces' => [
        // 'admin' => BASE_PATH . '/storage/view/vendor/admin',
    ],
];
