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

namespace Fangx\View\Contract;

interface EngineInterface
{
    /**
     * Get the evaluated contents of the view.
     *
     * @return string
     */
    public function get(string $path, array $data = []);
}
