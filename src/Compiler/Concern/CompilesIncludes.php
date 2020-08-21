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

trait CompilesIncludes
{
    /**
     * Compile the each statements into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileEach($expression)
    {
        return "<?php echo \$__env->renderEach{$expression}; ?>";
    }

    /**
     * Compile the include statements into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileInclude($expression)
    {
        $expression = $this->stripParentheses($expression);

        return "<?php echo \$__env->make({$expression}, \\Hyperf\\Utils\\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";
    }

    /**
     * Compile the include-if statements into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileIncludeIf($expression)
    {
        $expression = $this->stripParentheses($expression);

        return "<?php if (\$__env->exists({$expression})) echo \$__env->make({$expression}, \\Hyperf\\Utils\\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";
    }

    /**
     * Compile the include-when statements into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileIncludeWhen($expression)
    {
        $expression = $this->stripParentheses($expression);

        return "<?php echo \$__env->renderWhen({$expression}, \\Hyperf\\Utils\\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>";
    }

    /**
     * Compile the include-unless statements into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileIncludeUnless($expression)
    {
        $expression = $this->stripParentheses($expression);

        return "<?php echo \$__env->renderWhen(! {$expression}, \\Hyperf\\Utils\\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>";
    }

    /**
     * Compile the include-first statements into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileIncludeFirst($expression)
    {
        $expression = $this->stripParentheses($expression);

        return "<?php echo \$__env->first({$expression}, \\Hyperf\\Utils\\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";
    }
}
