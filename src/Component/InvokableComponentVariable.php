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

namespace Fangx\View\Component;

use ArrayIterator;
use Closure;
use Fangx\View\Contract\DeferringDisplayableValue;
use Fangx\View\Contract\Enumerable;
use Fangx\View\Contract\Htmlable;
use IteratorAggregate;

class InvokableComponentVariable implements DeferringDisplayableValue, IteratorAggregate
{
    /**
     * The callable instance to resolve the variable value.
     *
     * @var Closure
     */
    protected $callable;

    /**
     * Create a new variable instance.
     */
    public function __construct(Closure $callable)
    {
        $this->callable = $callable;
    }

    /**
     * Dynamically proxy attribute access to the variable.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->__invoke()->{$key};
    }

    /**
     * Dynamically proxy method access to the variable.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->__invoke()->{$method}(...$parameters);
    }

    /**
     * Resolve the variable.
     *
     * @return mixed
     */
    public function __invoke()
    {
        return call_user_func($this->callable);
    }

    /**
     * Resolve the variable as a string.
     *
     * @return mixed
     */
    public function __toString()
    {
        return (string)$this->__invoke();
    }

    /**
     * Resolve the displayable value that the class is deferring.
     *
     * @return Htmlable|string
     */
    public function resolveDisplayableValue()
    {
        return $this->__invoke();
    }

    /**
     * Get an interator instance for the variable.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        $result = $this->__invoke();

        return new ArrayIterator($result instanceof Enumerable ? $result->all() : $result);
    }
}
