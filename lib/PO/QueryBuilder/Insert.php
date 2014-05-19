<?php

/**
 * @see Gs_QueryBuilder_Abstract
 */
require_once 'Gs/QueryBuilder/Abstract.php';

/**
 * Helper for building INSERT SQL
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_Insert extends Gs_QueryBuilder_Abstract
{

    /**
     * @var string the table name
     */
    protected $_table;

    /**
     * @var array the values to insert into the table
     */
    protected $_values;

    /**
     * Set the table to insert data into
     *
     * @param string $table
     * @return Gs_QueryBuilder_Insert
     */
    public function into($table)
    {
        $this->_table = $table;
        return $this;
    }

    /**
     * @return string the table name to insert data into
     */
    public function getTable()
    {
        return $this->_table;
    }

    /**
     * Set the values to insert
     *
     * @param array $params key is the field and value is the value \o/
     * @return Gs_QueryBuilder_Insert
     */
    public function values(array $values = array())
    {
        $this->_values = $values; 
        return $this;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->_values;
    }

    public function getRawQuery()
    {
        $sql = array('INSERT INTO');
        $sql[] = $this->getTable();

        $values = $this->getValues();

        if (!empty($values)) {
            $columns = array_keys($values);

            $sql[] = '(' . implode(', ', $columns) . ')';
            $sql[] = 'VALUES';

            $columnValues = array();

            foreach ($values as $value) {
                $columnValues[] = $this->getHelper()->toDbValue($value);
            }

            $sql[] = '(' . implode(', ', $columnValues) . ')';
        }

        return implode(' ', $sql);
    }

}
