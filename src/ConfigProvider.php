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

namespace Fangx\View;

use Fangx\View\Command\FangxViewCommand;
use Fangx\View\Compiler\CompilerInterface;
use Fangx\View\Contract\EngineResolverInterface;
use Fangx\View\Contract\FactoryInterface;
use Fangx\View\Contract\FinderInterface;
use Fangx\View\Factory\CompilerFactory;
use Fangx\View\Factory\EngineResolverFactory;
use Fangx\View\Factory\FinderFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                FactoryInterface::class => Factory::class,
                EngineResolverInterface::class => EngineResolverFactory::class,
                FinderInterface::class => FinderFactory::class,
                CompilerInterface::class => CompilerFactory::class,
            ],
            'commands' => [
                FangxViewCommand::class,
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                    'collectors' => [
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for view.',
                    'source' => __DIR__ . '/../publish/view.php',
                    'destination' => BASE_PATH . '/config/autoload/view.php',
                ],
            ],
        ];
    }
}
