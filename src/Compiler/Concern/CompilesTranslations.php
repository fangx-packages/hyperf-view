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

trait CompilesTranslations
{
    /**
     * Compile the lang statements into valid PHP.
     *
     * @param null|string $expression
     * @return string
     */
    protected function compileLang($expression)
    {
        if (is_null($expression)) {
            return '<?php $__env->startTranslation(); ?>';
        }
        if ($expression[1] === '[') {
            return "<?php \$__env->startTranslation{$expression}; ?>";
        }

        return "<?php echo \\Fangx\\View\\T::translator()->get{$expression}; ?>";
    }

    /**
     * Compile the end-lang statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndlang()
    {
        return '<?php echo $__env->renderTranslation(); ?>';
    }

    /**
     * Compile the choice statements into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileChoice($expression)
    {
        return "<?php echo \\Fangx\\View\\T::translator()->choice{$expression}; ?>";
    }
}
