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

namespace Fangx\View\Compiler;

interface CompilerInterface
{
    /**
     * Get the path to the compiled version of a view.
     *
     * @param string $path
     * @return string
     */
    public function getCompiledPath($path);

    /**
     * Determine if the given view is expired.
     *
     * @param string $path
     * @return bool
     */
    public function isExpired($path);

    /**
     * Compile the view at the given path.
     *
     * @param string $path
     */
    public function compile($path);
}
