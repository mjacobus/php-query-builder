<?php

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_Helper
{

    /**
     * Quote value
     *
     * @param string $value
     * @return string
     */
    public function quote($value)
    {
        $escaped =  str_replace('"', '\"', $value);
        return '"' . $escaped . '"';
    }

    /**
     * Quote value if it is not a number or placeholder
     *
     * @param string $value
     * @return string
     */
    public function quoteIfNecessary($value)
    {
        if ($this->isNumber($value) || $this->isPlaceholder($value)) {
            return $value;
        }

        return $this->quote($value);
    }

    /**
     * Informs if given value is number
     * @param string $value
     * @return bool
     */
    public function isNumber($value)
    {
        return is_numeric($value);
    }

    /**
     * Informs if given value is a string
     * @param string $value
     * @return bool
     */
    public function isString($value)
    {
        return gettype($value) === 'string';
    }

    /**
     * Informs if given value is a placeholder
     * @param string $value
     * @return bool
     */
    public function isPlaceholder($value)
    {
        return preg_match('/^\:[_a-zA-Z]+$/', $value) === 1;
    }

    /**
     * Replace the given string with the given placeholders
     *
     * @param string $string
     * @param array $values the key value pair of placeholders
     * @return string the string to be replaced
     */
    public function replacePlaceholders($string, $values)
    {
        foreach($values as $placeholder => $value) {
            $string = str_replace(
                ":{$placeholder}",
                $this->quoteIfNecessary($value),
                $string
            );
        }
        return $string;
    }

    /**
     * Get the value that should be placed into the query
     * I.E:
     *     true     => TRUE
     *     "string" => "string"
     *     null     => NULL
     *
     *     To force return as it is
     *     array('value' => $someVar) => $someVar
     *
     * @param mixed $value
     * @return string
     */
    public function toDbValue($value)
    {
        if ($this->isString($value)){
            return $this->quoteIfNecessary($value);
        }

        // smelly code. Refactor

        if ($value === true) {
            return 'TRUE';
        }

        if ($value === false) {
            return 'FALSE';
        }

        if ($value === null) {
            return 'NULL';
        }

        if (is_array($value)) {
            if (isset($value['value'])) {
                return $value['value'];
            }
        }

        return $value;
    }
}
