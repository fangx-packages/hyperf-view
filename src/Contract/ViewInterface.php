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

interface ViewInterface extends Renderable
{
    /**
     * Get the name of the view.
     */
    public function name(): string;

    /**
     * Add a piece of data to the view.
     *
     * @param array|string $key
     * @param mixed $value
     * @return $this
     */
    public function with($key, $value = null);

    /**
     * Get the array of view data.
     */
    public function getData(): array;
}
