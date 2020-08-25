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

namespace Fangx\Tests;

use Fangx\Tests\Stub\Alert;
use Fangx\Tests\Stub\AlertSlot;
use Fangx\View\Contract\FactoryInterface;
use Fangx\View\HyperfViewEngine;
use Hyperf\Config\Config;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Container;
use Hyperf\Utils\ApplicationContext;
use Hyperf\View\Mode;
use PHPUnit\Framework\TestCase;

class ConfigRegisterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        /** @var Container $container */
        $container = ApplicationContext::getContainer();

        $container->set(ConfigInterface::class, new Config([
            'view' => [
                'engine' => HyperfViewEngine::class,
                'mode' => Mode::SYNC,
                'config' => [
                    'view_path' => __DIR__ . '/storage/view/',
                    'cache_path' => __DIR__ . '/storage/cache/',
                ],
                'components' => [
                    'alert' => Alert::class,
                    'alert-slot' => AlertSlot::class,
                ],
                'namespaces' => [
                    'admin' => __DIR__ . '/admin'
                ],
            ],
        ]));
    }

    public function testRegisterComponents()
    {
        $this->assertSame('success', $this->view('simple_8', ['message' => 'success']));
        $this->assertSame('success', $this->view('simple_9', ['message' => 'success']));
    }

    public function testRegisterNamespace()
    {
        $this->assertSame('from_admin', $this->view('admin::simple_3'));
        $this->assertSame('from_vendor', $this->view('admin::simple_4'));
    }

    protected function view(string $view, $data = [], array $mergeData = []): string
    {
        $container = ApplicationContext::getContainer();

        /** @var FactoryInterface $factory */
        $factory = $container->get(FactoryInterface::class);

        $content = $factory->make($view, $data, $mergeData)->render();

        return trim($content);
    }
}
