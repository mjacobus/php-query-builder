<?php

namespace PO\QueryBuilder;

/**
 * Helper for building INSERT SQL
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Insert extends Base
{

    /**
     * @var string the table name
     */
    protected $table;

    /**
     * @var array the values to insert into the table
     */
    protected $values;

    /**
     * Set the table to insert data into
     *
     * @param string $table
     * @return PO\QueryBuilder\Insert
     */
    public function into($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return string the table name to insert data into
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set the values to insert
     *
     * @param array $params key is the field and value is the value \o/
     * @return PO\QueryBuilder\Insert
     */
    public function values(array $values = array())
    {
        $this->values = $values;
        return $this;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
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
