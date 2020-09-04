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

namespace Fangx\View\Http\Middleware;

use Fangx\View\Contract\FactoryInterface;
use Fangx\View\ViewErrorBag;
use Hyperf\Contract\SessionInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ShareErrorsFromSession implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var FactoryInterface
     */
    protected $view;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->session = $container->get(SessionInterface::class);
        $this->view = $container->get(FactoryInterface::class);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var ViewErrorBag $errors */
        $errors = $this->session->get('errors') ?: new ViewErrorBag();

        $this->view->share('errors', $errors);

        return $handler->handle($request);
    }
}
