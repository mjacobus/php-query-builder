<?php

/**
 * @see Gs_View_Abstract
 */
require_once 'Gs/View.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_View_Phtml extends Gs_View
{

    /**
     * @var array
     */
    protected $_variables = array();

    /**
     * @var string
     */
    protected $_template;

    /**
     * Constructor.
     * I.E
     *    new Gs_View_Phtml(array(
     *        'template' => '/tmp/template.phtml',
     *        'variables' => array(
     *           'name' => 'Some Name'
     *        )
     *    ))
     *
     *
     *  Name will be accessible as $name in the view.
     *  Also, the instance of this class can be accessed via $this
     *
     * @param array $optios required
     */
    public function __construct(array $options)
    {
        if (isset($options['template'])) {
            $this->_template = $options['template'];
        } else {
            throw new InvalidArgumentException('Template was not informed');
        }

        if (isset($options['variables'])) {
            $this->_variables = $options['variables'];
        }
    }

    /**
     * The variables that should be binded to the template
     *
     * @return array
     */
    public function getVariables()
    {
        return $this->_variables;
    }

    /**
     * The template path
     * @return string
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * The content of the parsed file
     * @return string
     */
    public function render()
    {
        extract($this->getVariables());
        ob_start();
        require $this->getTemplate();
        return ob_get_clean();
    }

}
