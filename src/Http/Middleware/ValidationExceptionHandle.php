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
use Hyperf\Utils\Contracts\MessageProvider;
use Hyperf\Utils\MessageBag;
use Hyperf\Validation\ValidationException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class ValidationExceptionHandle implements MiddlewareInterface
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
        try {
            $response = $handler->handle($request);
        } catch (Throwable $throwable) {
            if ($this->isValid($throwable)) {
                /* @var ValidationException $throwable */
                $this->withErrors($throwable->errors(), $throwable->errorBag);
                return $this->response()->redirect($this->session->previousUrl());
            }

            throw $throwable;
        }

        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }

    public function withErrors($provider, $key = 'default')
    {
        $value = $this->parseErrors($provider);

        $errors = $this->session->get('errors', new ViewErrorBag());

        if (! $errors instanceof ViewErrorBag) {
            $errors = new ViewErrorBag();
        }

        $this->session->flash(
            'errors',
            $errors->put($key, $value)
        );

        return $this;
    }

    protected function response()
    {
        return $this->container->get(\Hyperf\HttpServer\Contract\ResponseInterface::class);
    }

    protected function parseErrors($provider)
    {
        if ($provider instanceof MessageProvider) {
            return $provider->getMessageBag();
        }

        return new MessageBag((array)$provider);
    }
}
