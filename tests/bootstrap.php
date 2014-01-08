<?php

define('LIB_PATH', realpath(dirname(__FILE__) . '/../lib'));

set_include_path(implode(PATH_SEPARATOR, array(
    LIB_PATH,
    get_include_path()
)));

require_once 'Gs/QueryBuilder.php';

