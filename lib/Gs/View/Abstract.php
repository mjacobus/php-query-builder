<?php

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
abstract class Gs_View_Abstract
{
    /**
     * @return string
     */
    public function render()
    {
        return 'Not Implemented';
    }

    /**
     * The string version of $this.
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
