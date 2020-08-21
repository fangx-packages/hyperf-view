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

namespace Fangx\Tests\Stub;

use Fangx\View\Component\Component;
use Fangx\View\Contract\FactoryInterface;
use Hyperf\Utils\ApplicationContext;

class Alert extends Component
{
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function render()
    {
        $factory = ApplicationContext::getContainer()
            ->get(FactoryInterface::class);

        return $factory->make('components.alert');
    }
}
