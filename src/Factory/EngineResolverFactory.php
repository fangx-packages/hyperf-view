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

namespace Fangx\View\Factory;

use Fangx\View\Engine\CompilerEngine;
use Fangx\View\Engine\EngineResolver;
use Fangx\View\Engine\FileEngine;
use Fangx\View\Engine\PhpEngine;
use Hyperf\Di\Container;

class EngineResolverFactory
{
    public function __invoke(Container $container)
    {
        return EngineResolver::getInstance([
            'blade' => CompilerEngine::class,
            'php' => PhpEngine::class,
            'file' => FileEngine::class,
        ]);
    }
}
