<?php

namespace SpiffyNavigation\View\Helper;

use InvalidArgumentException;
use SpiffyNavigation\AbstractContainer;
use SpiffyNavigation\Page\Page;
use SpiffyNavigation\Service\Navigation;
use Zend\View\Helper\AbstractHtmlElement;

abstract class AbstractHelper extends AbstractHtmlElement
{
    /**
     * @var Navigation
     */
    protected $navigation;

    /**
     * @param \SpiffyNavigation\Service\Navigation $navigation
     */
    public function __construct(Navigation $navigation)
    {
        $this->navigation = $navigation;
    }

    /**
     * Gets container from input.
     *
     * @param string|AbstractContainer $input
     * @return AbstractContainer
     * @throws InvalidArgumentException on invalid input.
     */
    protected function getContainer($input)
    {
        if (is_string($input)) {
            return $this->navigation->getContainer($input);
        } else if (!$input instanceof AbstractContainer) {
            throw new InvalidArgumentException('Container must be a string or instance of SpiffyNavigation\Container');
        }
        return $input;
    }

    /**
     * Cleans array of attributes based on valid input.
     *
     * @param array $input
     * @param array $valid
     */
    protected function cleanAttribs(array $input, array $valid)
    {
        foreach($input as $key => $value) {
            if (preg_match('/^data-(.+)/', $key) || in_array($key, $valid)) {
                continue;
            }
            unset($input[$key]);
        }

        return $input;
    }
}