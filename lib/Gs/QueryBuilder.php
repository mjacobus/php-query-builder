<?php

/**
 * @see Gs_QueryBuilder_Select
 */
require_once 'Gs/QueryBuilder/Select.php';

/**
 * Helper for building classes
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder extends Gs_QueryBuilder_Select
{

    /**
     * @deprecated
     *
     *     Please use Gs_QueryBuilder::factorySelect($fields) instead.
     *     Alternatively you can use new Gs_QueryBuilder_Select($params)
     */
    public function __construct(array $params = array())
    {
        parent::__construct($params);
    }

    /**
     * @params array $params The select filds for the select builder
     * @return Gs_QueryBuilder_Select
     */
    public static function factorySelect($params = array())
    {
        $select =  new Gs_QueryBuilder_Select();
        $select->select($params);
        return $select;
    }

}
