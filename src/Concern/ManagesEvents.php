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

namespace Fangx\View\Concern;

use Closure;
use Fangx\View\Container;
use Fangx\View\Contract\ViewInterface as ViewContract;
use Hyperf\Utils\Str;

trait ManagesEvents
{
    /**
     * Register a view creator event.
     *
     * @param array|string $views
     * @param Closure|string $callback
     * @return array
     */
    public function creator($views, $callback)
    {
        $creators = [];

        foreach ((array)$views as $view) {
            $creators[] = $this->addViewEvent($view, $callback, 'creating: ');
        }

        return $creators;
    }

    /**
     * Register multiple view composers via an array.
     *
     * @return array
     */
    public function composers(array $composers)
    {
        $registered = [];

        foreach ($composers as $callback => $views) {
            $registered = array_merge($registered, $this->composer($views, $callback));
        }

        return $registered;
    }

    /**
     * Register a view composer event.
     *
     * @param array|string $views
     * @param Closure|string $callback
     * @return array
     */
    public function composer($views, $callback)
    {
        $composers = [];

        foreach ((array)$views as $view) {
            $composers[] = $this->addViewEvent($view, $callback, 'composing: ');
        }

        return $composers;
    }

    /**
     * Call the composer for a given view.
     */
    public function callComposer(ViewContract $view)
    {
        // @TODO
        // $this->events->dispatch('composing: '.$view->name(), [$view]);
    }

    /**
     * Call the creator for a given view.
     */
    public function callCreator(ViewContract $view)
    {
        // @TODO
        // $this->events->dispatch('creating: '.$view->name(), [$view]);
    }

    /**
     * Add an event for a given view.
     *
     * @param string $view
     * @param Closure|string $callback
     * @param string $prefix
     * @return null|Closure
     */
    protected function addViewEvent($view, $callback, $prefix = 'composing: ')
    {
        $view = $this->normalizeName($view);

        if ($callback instanceof Closure) {
            $this->addEventListener($prefix . $view, $callback);

            return $callback;
        }
        if (is_string($callback)) {
            return $this->addClassEvent($view, $callback, $prefix);
        }
    }

    /**
     * Register a class based view composer.
     *
     * @param string $view
     * @param string $class
     * @param string $prefix
     * @return Closure
     */
    protected function addClassEvent($view, $class, $prefix)
    {
        $name = $prefix . $view;

        // When registering a class based view "composer", we will simply resolve the
        // classes from the application IoC container then call the compose method
        // on the instance. This allows for convenient, testable view composers.
        $callback = $this->buildClassEventCallback(
            $class,
            $prefix
        );

        $this->addEventListener($name, $callback);

        return $callback;
    }

    /**
     * Build a class based container callback Closure.
     *
     * @param string $class
     * @param string $prefix
     * @return Closure
     */
    protected function buildClassEventCallback($class, $prefix)
    {
        [$class, $method] = $this->parseClassEvent($class, $prefix);

        // Once we have the class and method name, we can build the Closure to resolve
        // the instance out of the IoC container and call the method on it with the
        // given arguments that are passed to the Closure as the composer's data.
        return function () use ($class, $method) {
            return call_user_func_array(
                [Container::getInstance()->make($class), $method],
                func_get_args()
            );
        };
    }

    /**
     * Parse a class based composer name.
     *
     * @param string $class
     * @param string $prefix
     * @return array
     */
    protected function parseClassEvent($class, $prefix)
    {
        return Str::parseCallback($class, $this->classEventMethodForPrefix($prefix));
    }

    /**
     * Determine the class event method based on the given prefix.
     *
     * @param string $prefix
     * @return string
     */
    protected function classEventMethodForPrefix($prefix)
    {
        return Str::contains($prefix, 'composing') ? 'compose' : 'create';
    }

    /**
     * Add a listener to the event dispatcher.
     *
     * @param string $name
     * @param Closure $callback
     */
    protected function addEventListener($name, $callback)
    {
        if (Str::contains($name, '*')) {
            $callback = function ($name, array $data) use ($callback) {
                return $callback($data[0]);
            };
        }

        // @TODO
        // $this->events->listen($name, $callback);
    }
}
