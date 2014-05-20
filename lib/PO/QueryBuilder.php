<?php

namespace PO;

use PO\QueryBuilder\Select;
use PO\QueryBuilder\Update;
use PO\QueryBuilder\Insert;

/**
 * Helper for building classes
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class QueryBuilder extends Select
{

    /**
     * @deprecated
     *
     *     Please use PO\QueryBuilder::factorySelect($fields) instead.
     *     Alternatively you can use new PO\QueryBuilder\Select($params)
     */
    public function __construct(array $params = array())
    {
        parent::__construct($params);
    }

    /**
     * Factory Select Builder
     *
     * @params array $params The select filds for the select builder
     * @return PO\QueryBuilder\Select
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
     * @param string $table the table to update
     * @return PO\QueryBuilder\Update
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
     * @param string $table the table to update
     * @return PO\QueryBuilder\Insert
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
