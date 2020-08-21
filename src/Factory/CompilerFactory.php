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

use Fangx\View\Compiler\BladeCompiler;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Container;
use Hyperf\Utils\Filesystem\Filesystem;

class CompilerFactory
{
    public function __invoke(Container $container)
    {
        return new BladeCompiler(
            $container->get(Filesystem::class),
            $container->get(ConfigInterface::class)->get('view.config.cache_path')
        );
    }
}
