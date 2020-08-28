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

use Fangx\View\Compiler\CompilerInterface;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Utils\ApplicationContext;

/**
 * Class Blade.
 *
 * @method static array getClassComponentAliases()
 * @method static array getCustomDirectives()
 * @method static array getExtensions()
 * @method static bool check(string $name, array ...$parameters)
 * @method static string compileString(string $value)
 * @method static string getPath()
 * @method static string stripParentheses(string $expression)
 * @method static void aliasComponent(string $path, null|string $alias = null)
 * @method static void aliasInclude(string $path, null|string $alias = null)
 * @method static void compile(null|string $path = null)
 * @method static void component(string $class, null|string $alias = null, string $prefix = '')
 * @method static void components(array $components, string $prefix = '')
 * @method static void directive(string $name, callable $handler)
 * @method static void extend(callable $compiler)
 * @method static void if (string $name, callable $callback)
 * @method static void include (string $path, string|null $alias = null)
 * @method static void precompiler(callable $precompiler)
 * @method static void setEchoFormat(string $format)
 * @method static void setPath(string $path)
 * @method static void withDoubleEncoding()
 * @method static void withoutComponentTags()
 * @method static void withoutDoubleEncoding()
 */
class Blade
{
    /**
     * @var \Hyperf\Contract\ContainerInterface
     */
    protected static $container;

    public static function __callStatic($method, $args)
    {
        return static::resolve()->{$method}(...$args);
    }

    public static function resolve()
    {
        return static::container()
            ->get(CompilerInterface::class);
    }

    public static function container()
    {
        return static::$container ?: static::$container = ApplicationContext::getContainer();
    }

    public static function config($key, $default = '')
    {
        $key = 'view.' . $key;

        return static::container()
            ->get(ConfigInterface::class)
            ->get($key, $default);
    }
}
