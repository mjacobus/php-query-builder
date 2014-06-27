<?php

namespace PO;

use PO\QueryBuilder\Statements\Select;
use PO\QueryBuilder\Statements\Update;
use PO\QueryBuilder\Statements\Insert;

/**
 * Helper for building classes
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class QueryBuilder extends Select
{

    /**
     * Factory Select Builder
     *
     * @params array $params The select filds for the select builder
     * @return Select
     */
    public static function factorySelect($params = array())
    {
        $select = new Select();
        $select->select($params);

        return $select;
    }

    /**
     * Factory Update Builder
     *
     * @param  string $table the table to update
     * @return Update
     */
    public static function update($table = null)
    {
        $query = new Update();

        if ($table) {
            $query->table($table);
        }

        return $query;
    }

    /**
     * Factory Insert Builder
     *
     * @param  string $table the table to update
     * @return Insert
     */
    public static function insert($table = null)
    {
        $query = new Insert();

        if ($table) {
            $query->into($table);
        }

        return $query;
    }
}
