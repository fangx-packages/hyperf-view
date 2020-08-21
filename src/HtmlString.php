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

namespace Fangx\View;

use Fangx\View\Contract\Htmlable;

class HtmlString implements Htmlable
{
    /**
     * The HTML string.
     *
     * @var string
     */
    protected $html;

    /**
     * Create a new HTML string instance.
     *
     * @param string $html
     */
    public function __construct($html = '')
    {
        $this->html = $html;
    }

    /**
     * Get the HTML string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    /**
     * Get the HTML string.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->html;
    }

    /**
     * Determine if the given HTML string is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->html === '';
    }
}
