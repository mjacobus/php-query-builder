# PO Query Builder

Query Builder for easing the SQL composing

[![Build Status](https://travis-ci.org/mjacobus/php-query-builder.png?branch=master)](https://travis-ci.org/mjacobus/php-objects)
[![Coverage Status](https://coveralls.io/repos/mjacobus/php-query-builder/badge.png)](https://coveralls.io/r/mjacobus/php-objects)

## Usage

```php
$insert = PO\QueryBuilder::insert();

// Alternatively

$insert = new new PO\QueryBuilder\Insert($values);

$insert->into('users')->values(array(
        'name' => 'Jon Doe',
        'email' => 'jon@doe.com'
    ));


$insert->toSql();
// INSERT INTO users (name, email) VALUES ('Jon Doe', 'jon@doe.com');
```
### Insert

```php

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
