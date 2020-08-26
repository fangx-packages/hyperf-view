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
use Fangx\View\Contract\ViewInterface;
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

    public function testViewFunction()
    {
        $this->assertInstanceOf(FactoryInterface::class, view());
        $this->assertInstanceOf(ViewInterface::class, view('index'));
    }

    public function testHyperfEngine()
    {
        $engine = new HyperfViewEngine();

        $this->assertSame('<h1>fangx/view</h1>', $engine->render('index', [], []));
        $this->assertSame('<h1>fangx</h1>', $engine->render('home', ['user' => 'fangx'], []));
    }

    public function testRender()
    {
        $this->assertSame('<h1>fangx/view</h1>',trim((string)view('index')));
        $this->assertSame('<h1>fangx</h1>', trim((string)view('home', ['user' => 'fangx'])));
        // *.php
        $this->assertSame('fangx', trim((string)view('simple_1')));
        // *.html
        $this->assertSame('fangx', trim((string)view('simple_2')));
        // @extends & @yield & @section..@stop
        $this->assertSame('yield-content', trim((string)view('simple_5')));
        // @if..@else..@endif
        $this->assertSame('fangx', trim((string)view('simple_6')));
        // @{{ name }}
        $this->assertSame('{{ name }}', trim((string)view('simple_7')));
        // @json()
        $this->assertSame('{"email":"nfangxu@gmail.com","name":"fangx"}', trim((string)view('simple_10')));
    }

    public function testUseNamespace()
    {
        /** @var FactoryInterface $factory */
        $factory = ApplicationContext::getContainer()->get(FactoryInterface::class);
        $factory->addNamespace('admin', __DIR__ . '/admin');

        $this->assertSame('from_admin', trim((string)view('admin::simple_3')));
        $this->assertSame('from_vendor', trim((string)view('admin::simple_4')));
    }

    public function testComponent()
    {
        /** @var BladeCompiler $compiler */
        $compiler = ApplicationContext::getContainer()
            ->get(CompilerInterface::class);

        $compiler->component(Alert::class, 'alert');
        $compiler->component(AlertSlot::class, 'alert-slot');

        $this->assertSame('success', trim((string)view('simple_8', ['message' => 'success'])));
        $this->assertSame('success', trim((string)view('simple_9', ['message' => 'success'])));
    }
}
