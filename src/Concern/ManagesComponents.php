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

namespace Fangx\View\Concern;

use Closure;
use Fangx\View\HtmlString;
use Fangx\View\View;
use Hyperf\Utils\Arr;
use InvalidArgumentException;

trait ManagesComponents
{
    /**
     * The components being rendered.
     *
     * @var array
     */
    protected $componentStack = [];

    /**
     * The original data passed to the component.
     *
     * @var array
     */
    protected $componentData = [];

    /**
     * The slot contents for the component.
     *
     * @var array
     */
    protected $slots = [];

    /**
     * The names of the slots being rendered.
     *
     * @var array
     */
    protected $slotStack = [];

    /**
     * Start a component rendering process.
     *
     * @param Closure|string|View $view
     */
    public function startComponent($view, array $data = [])
    {
        if (ob_start()) {
            $this->componentStack[] = $view;

            $this->componentData[$this->currentComponent()] = $data;

            $this->slots[$this->currentComponent()] = [];
        }
    }

    /**
     * Get the first view that actually exists from the given list, and start a component.
     */
    public function startComponentFirst(array $names, array $data = [])
    {
        $name = Arr::first($names, function ($item) {
            return $this->exists($item);
        });

        $this->startComponent($name, $data);
    }

    /**
     * Render the current component.
     *
     * @return string
     */
    public function renderComponent()
    {
        $view = array_pop($this->componentStack);

        $data = $this->componentData();

        if ($view instanceof Closure) {
            $view = $view($data);
        }

        if ($view instanceof View) {
            return $view->with($data)->render();
        }
        return $this->make($view, $data)->render();
    }

    /**
     * Start the slot rendering process.
     *
     * @param string $name
     * @param null|string $content
     */
    public function slot($name, $content = null)
    {
        if (func_num_args() > 2) {
            throw new InvalidArgumentException('You passed too many arguments to the [' . $name . '] slot.');
        }
        if (func_num_args() === 2) {
            $this->slots[$this->currentComponent()][$name] = $content;
        } elseif (ob_start()) {
            $this->slots[$this->currentComponent()][$name] = '';

            $this->slotStack[$this->currentComponent()][] = $name;
        }
    }

    /**
     * Save the slot content for rendering.
     */
    public function endSlot()
    {
        last($this->componentStack);

        $currentSlot = array_pop(
            $this->slotStack[$this->currentComponent()]
        );

        $this->slots[$this->currentComponent()][$currentSlot] = new HtmlString(trim(ob_get_clean()));
    }

    /**
     * Get the data for the given component.
     *
     * @return array
     */
    protected function componentData()
    {
        return array_merge(
            $this->componentData[count($this->componentStack)],
            ['slot' => new HtmlString(trim(ob_get_clean()))],
            $this->slots[count($this->componentStack)]
        );
    }

    /**
     * Get the index for the current component.
     *
     * @return int
     */
    protected function currentComponent()
    {
        return count($this->componentStack) - 1;
    }
}
