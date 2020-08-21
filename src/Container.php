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

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Utils\ApplicationContext;

class Container
{
    public static function getInstance(): ContainerInterface
    {
        return ApplicationContext::getContainer();
    }

    public static function config()
    {
        return static::getInstance()->get(ConfigInterface::class);
    }
}
