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

use Fangx\View\Factory as ViewFactory;

trait CompilesLayouts
{
    /**
     * The name of the last section that was started.
     *
     * @var string
     */
    protected $lastSection;

    /**
     * Compile the extends statements into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileExtends($expression)
    {
        $expression = $this->stripParentheses($expression);

        $echo = "<?php echo \$__env->make({$expression}, \\Hyperf\\Utils\\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";

        $this->footer[] = $echo;

        return '';
    }

    /**
     * Compile the section statements into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileSection($expression)
    {
        $this->lastSection = trim($expression, "()'\" ");

        return "<?php \$__env->startSection{$expression}; ?>";
    }

    /**
     * Replace the @parent directive to a placeholder.
     *
     * @return string
     */
    protected function compileParent()
    {
        return ViewFactory::parentPlaceholder($this->lastSection ?: '');
    }

    /**
     * Compile the yield statements into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileYield($expression)
    {
        return "<?php echo \$__env->yieldContent{$expression}; ?>";
    }

    /**
     * Compile the show statements into valid PHP.
     *
     * @return string
     */
    protected function compileShow()
    {
        return '<?php echo $__env->yieldSection(); ?>';
    }

    /**
     * Compile the append statements into valid PHP.
     *
     * @return string
     */
    protected function compileAppend()
    {
        return '<?php $__env->appendSection(); ?>';
    }

    /**
     * Compile the overwrite statements into valid PHP.
     *
     * @return string
     */
    protected function compileOverwrite()
    {
        return '<?php $__env->stopSection(true); ?>';
    }

    /**
     * Compile the stop statements into valid PHP.
     *
     * @return string
     */
    protected function compileStop()
    {
        return '<?php $__env->stopSection(); ?>';
    }

    /**
     * Compile the end-section statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndsection()
    {
        return '<?php $__env->stopSection(); ?>';
    }
}
