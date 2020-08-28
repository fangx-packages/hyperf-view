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

use Fangx\View\Blade;
use Fangx\View\Compiler\BladeCompiler;
use Hyperf\Di\Container;
use Hyperf\Utils\Filesystem\Filesystem;

class CompilerFactory
{
    public function __invoke(Container $container)
    {
        $blade = new BladeCompiler(
            $container->get(Filesystem::class),
            Blade::config('config.cache_path')
        );

        // register view components
        foreach ((array)Blade::config('components', []) as $alias => $class) {
            $blade->component($class, $alias);
        }

        return $blade;
    }
}
