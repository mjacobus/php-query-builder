<?php
/**
 * @see Gs_QueryBuilder_Statement
 */
require_once 'Gs/QueryBuilder/Statement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_SetStatement extends Gs_QueryBuilder_Statement
{

    /**
     * Set (override) the values to be set
     *
     * @param array $values
     * @return Gs_QueryBuilder_SetStatement
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
     * @return Gs_QueryBuilder_SetStatement
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
     * @return Gs_QueryBuilder_SetStatement
     */
    public function addSet($column, $value)
    {
        $this->_params[$column] = $value;
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

        foreach($params as $column => $value) {
            $set[] = implode(' = ', array(
                $column, $this->getBuilder()->getHelper()->quoteIfNecessary($value)
            ));
        }

        $sql[] = implode(', ', $set);

        return implode(' ', $sql);
    }

}
