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

use Fangx\View\Contract\DeferringDisplayableValue;
use Fangx\View\Contract\Htmlable;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Utils\ApplicationContext;

class T
{
    /**
     * Encode HTML special characters in a string.
     *
     * @param DeferringDisplayableValue|Htmlable|string $value
     * @param bool $doubleEncode
     * @return string
     */
    public static function e($value, $doubleEncode = true)
    {
        if ($value instanceof DeferringDisplayableValue) {
            $value = $value->resolveDisplayableValue();
        }

        if ($value instanceof Htmlable) {
            return $value->toHtml();
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', $doubleEncode);
    }

    public static function inject($name)
    {
        return ApplicationContext::getContainer()
            ->get($name);
    }

    public static function translator()
    {
        return ApplicationContext::getContainer()
            ->get(TranslatorInterface::class);
    }
}
