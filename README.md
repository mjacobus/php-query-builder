# PO Query Builder

Query Builder for easing the SQL composing

[![Build Status](https://travis-ci.org/mjacobus/php-query-builder.png?branch=master)](https://travis-ci.org/mjacobus/php-objects)
[![Coverage Status](https://coveralls.io/repos/mjacobus/php-query-builder/badge.png)](https://coveralls.io/r/mjacobus/php-objects)

## Usage

### Select

This is an example of select query. ```limit```, ```where```, ```groupBy```, ```limit``` can be applied to it.

```php
$fields = array('u.name AS name', 'r.name AS role');

// Selecting via factory
$select = PO\QueryBuilder::factorySelect($fields);

// Selecting via the select method
$select = PO\QueryBuilder::factorySelect()
    ->select($fields);

// or alternatively
$select = new PO\QueryBuilder\Select($fields);

// or yet
$select = new PO\QueryBuilder\Select();
$select->select($fields);

// From
$select->from('users u');

// Adding joins
$select->innerJoin('roles r', 'u.id = r.user_id');

$select->toSql();

// SELECT u.name AS name, r.name AS role FROM users u INNER JOIN roles r ON u.idi = r.user_id

```

### Insert

```php
// Using the factory
$insert = PO\QueryBuilder::insert();

// Or alternatively
$insert = new PO\QueryBuilder\Insert($values);

$insert->into('users')->values(array(
    'name'  => 'Jon Doe',
    'email' => 'jon@doe.com'
));

$insert->toSql();

// INSERT INTO users (name, email) VALUES ('Jon Doe', 'jon@doe.com');
```

### Using place holders

Placeholders are a good way for building your queries when you don't know what values are goint to be used (because they depend on the result of a query yet to be executed, for instance).

```php
$insert->into('users')->values(array(
    'name'  => ':name',
    'email' => ':email'
));

$insert->toSql(array(
    'name'  => 'Jon Doe',
    'email' => 'jon@doe.com'
));

// INSERT INTO users (name, email) VALUES ('Jon Doe', 'jon@doe.com');
```

### Update
```php

```

### Delete

TODO: Implement

## Issues/New Features

[Here](issues) is the issue tracker.

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request

**Do not forget to write tests**

**Keep the code standard [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)

**Keep the code coverage [![Coverage Status](https://coveralls.io/repos/mjacobus/php-query-builder/badge.png)](https://coveralls.io/r/mjacobus/php-objects)**
### How to run the tests:

```bash
phpunit --configuration tests/phpunit.xml
```

### To check the code standard run:

```bash
phpcs --standard=PSR2 lib
phpcs --standard=PSR2 tests

# alternatively

./bin/travis/run_phpcs.sh
```
