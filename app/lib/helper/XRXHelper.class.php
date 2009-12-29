<?php

/**
 * The base helper from which all helpers inherit.
 */
class XRXHelper implements XRXIHelper
{
    /**
     * View object
     *
     * @var AgaviView
     */
    public $view = null;

    /**
     * Set the View object
     *
     * @param  AgaviView $view
     * @return XRXIHelper
     */
    public function setView(AgaviView $view)
    {
        $this->view = $view;
        return $this;
    }
}

?>