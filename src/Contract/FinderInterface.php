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

interface FinderInterface
{
    /**
     * Hint path delimiter value.
     *
     * @var string
     */
    const HINT_PATH_DELIMITER = '::';

    /**
     * Get the fully qualified location of the view.
     *
     * @return string
     */
    public function find(string $view);

    /**
     * Add a location to the finder.
     */
    public function addLocation(string $location);

    /**
     * Add a namespace hint to the finder.
     *
     * @param array|string $hints
     */
    public function addNamespace(string $namespace, $hints);

    /**
     * Prepend a namespace hint to the finder.
     *
     * @param array|string $hints
     */
    public function prependNamespace(string $namespace, $hints);

    /**
     * Replace the namespace hints for the given namespace.
     *
     * @param array|string $hints
     */
    public function replaceNamespace(string $namespace, $hints);

    /**
     * Add a valid view extension to the finder.
     */
    public function addExtension(string $extension);

    /**
     * Flush the cache of located views.
     */
    public function flush();
}
