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
use Fangx\View\Compiler\BladeCompiler;
use Fangx\View\Compiler\CompilerInterface;
use Fangx\View\Contract\FactoryInterface;
use Fangx\View\HyperfViewEngine;
use Hyperf\Config\Config;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Container;
use Hyperf\Utils\ApplicationContext;
use Hyperf\View\Mode;
use PHPUnit\Framework\TestCase;

class BladeTest extends TestCase
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
            ],
        ]));
    }

    public function testHyperfEngine()
    {
        $engine = new HyperfViewEngine();

        $this->assertSame('<h1>fangx/view</h1>', $engine->render('index', [], []));
        $this->assertSame('<h1>fangx</h1>', $engine->render('home', ['user' => 'fangx'], []));
    }

    public function testRender()
    {
        $this->assertSame('<h1>fangx/view</h1>', $this->view('index'));
        $this->assertSame('<h1>fangx</h1>', $this->view('home', ['user' => 'fangx']));
        // *.php
        $this->assertSame('fangx', $this->view('simple_1'));
        // *.html
        $this->assertSame('fangx', $this->view('simple_2'));
        // @extends & @yield & @section..@stop
        $this->assertSame('yield-content', $this->view('simple_5'));
        // @if..@else..@endif
        $this->assertSame('fangx', $this->view('simple_6'));
        // @{{ name }}
        $this->assertSame('{{ name }}', $this->view('simple_7'));
    }

    public function testUseNamespace()
    {
        /** @var FactoryInterface $factory */
        $factory = ApplicationContext::getContainer()->get(FactoryInterface::class);
        $factory->addNamespace('admin', __DIR__ . '/admin');

        $this->assertSame('from_admin', $this->view('admin::simple_3'));
        $this->assertSame('from_vendor', $this->view('admin::simple_4'));
    }

    public function testComponent()
    {
        /** @var BladeCompiler $compiler */
        $compiler = ApplicationContext::getContainer()
            ->get(CompilerInterface::class);

        $compiler->component(Alert::class, 'alert');
        $compiler->component(AlertSlot::class, 'alert-slot');

        $this->assertSame('success', $this->view('simple_8', ['message' => 'success']));
        $this->assertSame('success', $this->view('simple_9', ['message' => 'success']));
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
