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

namespace Fangx\View\Contract;

use Closure;

interface EngineResolverInterface
{
    public function register(string $engine, Closure $resolver);

    public function resolve(string $engine): EngineInterface;
}
