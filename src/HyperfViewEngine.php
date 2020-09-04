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

use Fangx\View\Contract\FactoryInterface;
use Hyperf\Utils\ApplicationContext;
use Hyperf\View\Engine\EngineInterface;

class HyperfViewEngine implements EngineInterface
{
    public function render($template, $data, $config): string
    {
        /** @var FactoryInterface $factory */
        $factory = ApplicationContext::getContainer()->get(FactoryInterface::class);

        return $factory->make($template, $data)->render();
    }
}
