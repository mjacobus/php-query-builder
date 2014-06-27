<?php

namespace PO\QueryBuilder\Statements;

use PO\QueryBuilder;
use PO\QueryBuilder\Helper;

/**
 * Helper for building classes
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
abstract class Base
{
    /**
     * @var Helper
     */
    protected $helper;

    /**
     * Constructor
     *
     * @param array $options Hash of options
     *                       Allowed options:
     *                       helper: Helper
     */
    public function __construct($options = array())
    {

        if (isset($options['helper'])) {
            $helper = $options['helper'];
        } else {
            $helper = new Helper;
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
     * @param  Helper $helper
     * @return self
     */
    public function setHelper(Helper $helper)
    {
        $this->helper = $helper;

        return $this;
    }

    /**
     * Get the helper
     *
     * @return self
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * Converts to the desired sql
     *
     * @param  array  $params the placeholders to replace for
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

        foreach ($this->getClauses() as $clause) {
            if (!$clause->isEmpty()) {
                $sql[] = $clause;
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
