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

use Fangx\View\Contract\FactoryInterface;
use Fangx\View\Contract\ViewInterface;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Context;
use Hyperf\Utils\Contracts\Arrayable;
use Psr\Http\Message\ResponseInterface;

if (! function_exists('view')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param null|string $view
     * @param array|Arrayable $data
     * @param array $mergeData
     * @return FactoryInterface|ViewInterface
     */
    function view($view = null, $data = [], $mergeData = [])
    {
        if (interface_exists(ResponseInterface::class) && Context::has(ResponseInterface::class)) {
            Context::set(
                ResponseInterface::class,
                Context::get(ResponseInterface::class)
                    ->withAddedHeader('content-type', 'text/html')
            );
        }

        /** @var FactoryInterface $factory */
        $factory = ApplicationContext::getContainer()->get(FactoryInterface::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($view, $data, $mergeData);
    }
}
