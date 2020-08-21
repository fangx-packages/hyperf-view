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

use Fangx\View\Contract\EngineInterface;

class FileEngine implements EngineInterface
{
    /**
     * Get the evaluated contents of the view.
     *
     * @return string
     */
    public function get(string $path, array $data = [])
    {
        return file_get_contents($path);
    }
}
