<?php

namespace PO\QueryBuilder;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class SetStatement extends Statement
{

    /**
     * Set (override) the values to be set
     *
     * @param array $values
     * @return PO\QueryBuilder\SetStatement
     */
    public function set(array $params = array())
    {
        $this->setParams(array())->addSets($params);
        return $this;
    }

    /**
     * Add the values to be set
     *
     * @param array $values
     * @return PO\QueryBuilder\SetStatement
     */
    public function addSets(array $values = array())
    {
        foreach ($values as $column => $value) {
            $this->addSet($column, $value);
        }

        return $this;
    }

    /**
     * Add the values to be set
     *
     * @param string $column
     * @param string $value
     * @return PO\QueryBuilder\SetStatement
     */
    public function addSet($column, $value)
    {
        $this->params[$column] = $value;
        return $this;
    }

    /**
     * The SET query part
     *
     * @return string
     */
    public function toSql()
    {
        if ($this->isEmpty()) {
            return '';
        }

        $params = $this->getParams();

        $sql = array('SET');
        $set = array();

        foreach ($params as $column => $value) {
            $set[] = implode(' = ', array(
                $column, $this->getBuilder()->getHelper()->toDbValue($value)
            ));
        }

        $sql[] = implode(', ', $set);

        return implode(' ', $sql);
    }
}
