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

use Hyperf\Utils\Filesystem\Filesystem;
use InvalidArgumentException;

abstract class Compiler
{
    /**
     * The Filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Get the cache path for the compiled views.
     *
     * @var string
     */
    protected $cachePath;

    /**
     * Create a new compiler instance.
     *
     * @param string $cachePath
     *
     * @throws InvalidArgumentException
     */
    public function __construct(Filesystem $files, $cachePath)
    {
        if (! $cachePath) {
            throw new InvalidArgumentException('Please provide a valid cache path.');
        }

        $this->files = $files;

        if (! $this->files->exists($cachePath)) {
            $this->files->makeDirectory($cachePath);
        }

        $this->cachePath = $cachePath;
    }

    /**
     * Get the path to the compiled version of a view.
     *
     * @param string $path
     * @return string
     */
    public function getCompiledPath($path)
    {
        return $this->cachePath . '/' . sha1($path) . '.php';
    }

    /**
     * Determine if the view at the given path is expired.
     *
     * @param string $path
     * @return bool
     */
    public function isExpired($path)
    {
        $compiled = $this->getCompiledPath($path);

        // If the compiled file doesn't exist we will indicate that the view is expired
        // so that it can be re-compiled. Else, we will verify the last modification
        // of the views is less than the modification times of the compiled views.
        if (! $this->files->exists($compiled)) {
            return true;
        }

        return $this->files->lastModified($path) >=
            $this->files->lastModified($compiled);
    }
}
