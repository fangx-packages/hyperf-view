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

namespace Fangx\View\Compiler\Concern;

trait CompilesInjections
{
    /**
     * Compile the inject statements into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileInject($expression)
    {
        $segments = explode(',', preg_replace("/[\\(\\)\\\"\\']/", '', $expression));

        $variable = trim($segments[0]);

        $service = trim($segments[1]);

        return "<?php \${$variable} = \\Fangx\\View\\T::inject('{$service}'); ?>";
    }
}
