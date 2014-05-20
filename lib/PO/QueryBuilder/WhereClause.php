<?php

namespace PO\QueryBuilder;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class WhereClause extends Statement
{

    /**
     * Add a condition. I.E:
     *
     *     $this->addContition('a = 2')
     *     $this->addContition('a', 2)
     *     $this->addContition('a', '2', '!=')
     *
     *
     * @param string $fieldOrCondition
     * @param string $value
     * @param string $operator
     * @return PO\QueryBuilder\WhereClause
     */
    public function addCondition($fieldOrCondition, $value = null, $operator = '=')
    {
        $parts = array($fieldOrCondition);

        if ($value !== null) {
            $parts[] = $operator;
            $parts[] = $this->getBuilder()->getHelper()->toDbValue($value);
        }

        $this->addParam(implode(' ', $parts));

        return $this;
    }

    /**
     * Add contitions to the statement
     * I.E.
     *
     *   $this->o->addConditions(array(
     *       'a = "b"',
     *       array('x', 1),
     *       array('x', '1', '!=')
     *   ));
     *
     * @param array $conditions
     * @return PO\QueryBuilder\WhereClause
     */
    public function addConditions(array $conditions = array())
    {
        foreach ($conditions as $key => $condition) {
            if (is_array($condition)) {
                call_user_func_array(array($this, 'addCondition'), $condition);
            } elseif (!$this->getBuilder()->getHelper()->isNumber($key)) {
                call_user_func_array(array($this, 'addCondition'), array($key, $condition));
            } else {
                $this->addCondition($condition);
            }
        }

        return $this;
    }


    /**
     * Return the resulting query
     * @return string
     */
    public function toSql()
    {
        if ($this->isEmpty()) {
            return '';
        } else {
            return 'WHERE ' . implode(' AND ', $this->getParams());
        }
    }
}
