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
use Fangx\View\Finder;
use Hyperf\Di\Container;
use Hyperf\Utils\Filesystem\Filesystem;

class FinderFactory
{
    public function __invoke(Container $container)
    {
        $finder = new Finder(
            $container->get(Filesystem::class),
            (array)Blade::config('config.view_path')
        );

        // register view namespace
        foreach ((array)Blade::config('namespaces', []) as $namespace => $hints) {
            foreach ($finder->getPaths() as $viewPath) {
                if (is_dir($appPath = $viewPath . '/vendor/' . $namespace)) {
                    $finder->addNamespace($namespace, $appPath);
                }
            }

            $finder->addNamespace($namespace, $hints);
        }

        return $finder;
    }
}
