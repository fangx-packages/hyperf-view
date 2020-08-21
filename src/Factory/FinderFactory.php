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

use Fangx\View\Finder;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Container;
use Hyperf\Utils\Filesystem\Filesystem;

class FinderFactory
{
    public function __invoke(Container $container)
    {
        return new Finder(
            $container->get(Filesystem::class),
            (array)$container->get(ConfigInterface::class)->get('view.config.view_path')
        );
    }
}
