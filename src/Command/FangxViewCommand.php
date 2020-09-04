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

namespace Fangx\View\Command;

use Hyperf\Command\Command as HyperfCommand;

class FangxViewCommand extends HyperfCommand
{
    protected $signature = 'fangx:view {--f|force}';

    protected $packages = [
        'hyperf/session',
        'hyperf/validation',
    ];

    public function handle()
    {
        $this->call('vendor:publish', [
            'package' => 'fangx/view',
            '--force' => true,
        ]);

        foreach ($this->packages as $package) {
            $this->call('vendor:publish', [
                'package' => $package,
                '--force' => $this->input->getOption('force') === false ? false : true,
            ]);
        }
    }
}
