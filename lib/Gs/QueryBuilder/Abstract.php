<?php

/**
 * @see Gs_QueryBuilder_Helper
 */
require_once 'Gs/QueryBuilder/Helper.php';

/**
 * Helper for building classes
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_Abstract
{
    /**
     * @var Gs_QueryBuilder_Helper
     */
    protected $_helper;


    /**
     * Constructor
     *
     * @param array $options Hash of options
     *              Allowed options:
     *                  helper: Gs_QueryBuilder_Helper
     */
    public function __construct($options = array())
    {

        if (isset($options['helper'])) {
            $helper = $options['helper'];
        } else {
            $helper = new Gs_QueryBuilder_Helper;
        }

        $this->setHelper($helper);

        $this->initialize();
    }

    /**
     * Here is where the setup should happen
     */
    public function initialize()
    {
    }

    /**
     * Set the helper
     *
     * @param Gs_QueryBuilder_Helper $helper
     * @return Gs_QueryBuilder
     */
    public function setHelper(Gs_QueryBuilder_Helper $helper)
    {
        $this->_helper = $helper;
        return $this;
    }

    /**
     * Get the helper
     *
     * @return Gs_QueryBuilder_Helper
     */
    public function getHelper()
    {
        return $this->_helper;
    }

    /**
     * Converts to the desired sql
     *
     * @param array $params the placeholders to replace for
     * @return string
     */
    public function toSql(array $params = array())
    {
        $sql = $this->getRawQuery();

        if (empty($params)) {
            return $sql;
        } else {
            return $this->getHelper()->replacePlaceholders($sql, $params);
        }
    }

    /**
     * Get the sql without any replacements
     * @return string
     */
    public function getRawQuery()
    {
        $sql = array();

        foreach ($this->getStatements() as $statement) {
            if (!$statement->isEmpty()) {
                $sql[] = $statement;
            }
        }

        return implode(' ', $sql);
    }

    /**
     * Alias to toSql()
     * @return string
     */
    public function __toString()
    {
        return $this->toSql();
    }

}
