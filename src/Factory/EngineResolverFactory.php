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

use Fangx\View\Compiler\CompilerInterface;
use Fangx\View\Engine\CompilerEngine;
use Fangx\View\Engine\EngineResolver;
use Fangx\View\Engine\FileEngine;
use Fangx\View\Engine\PhpEngine;
use Hyperf\Di\Container;

class EngineResolverFactory
{
    public function __invoke(Container $container)
    {
        $resolver = new EngineResolver();

        $resolver->register('blade', function () use ($container) {
            return new CompilerEngine($container->get(CompilerInterface::class));
        });

        $resolver->register('php', function () {
            return new PhpEngine();
        });

        $resolver->register('file', function () {
            return new FileEngine();
        });

        return $resolver;
    }
}
