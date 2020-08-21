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

use Fangx\View\ConfigProvider;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSource;
use Hyperf\Event\EventDispatcher;
use Hyperf\Event\ListenerProvider;
use Hyperf\Utils\ApplicationContext;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

require __DIR__ . '/../vendor/autoload.php';

$dependencies = (new ConfigProvider())()['dependencies'];

$container = new Container(new DefinitionSource(array_merge([
    EventDispatcherInterface::class => EventDispatcher::class,
    ListenerProviderInterface::class => ListenerProvider::class,
], $dependencies)));

ApplicationContext::setContainer($container);
