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

namespace Fangx\View\Engine;

use Closure;
use Fangx\View\Contract\EngineInterface;
use Fangx\View\Contract\EngineResolverInterface;
use InvalidArgumentException;

class EngineResolver implements EngineResolverInterface
{
    /**
     * The array of engine resolvers.
     *
     * @var array
     */
    protected $resolvers = [];

    /**
     * The resolved engine instances.
     *
     * @var array
     */
    protected $resolved = [];

    /**
     * Register a new engine resolver.
     *
     * The engine string typically corresponds to a file extension.
     */
    public function register(string $engine, Closure $resolver)
    {
        unset($this->resolved[$engine]);

        $this->resolvers[$engine] = $resolver;
    }

    /**
     * Resolve an engine instance by name.
     *
     * @throws InvalidArgumentException
     */
    public function resolve(string $engine): EngineInterface
    {
        if (isset($this->resolved[$engine])) {
            return $this->resolved[$engine];
        }

        if (isset($this->resolvers[$engine])) {
            return $this->resolved[$engine] = call_user_func($this->resolvers[$engine]);
        }

        throw new InvalidArgumentException("Engine [{$engine}] not found.");
    }
}
