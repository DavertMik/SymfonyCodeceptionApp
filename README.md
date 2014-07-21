Symfony Codeception App
=====================

Sample Symfony App (based on AcmeDemoBundle) functionally tested with [Codeception](http://codeception.com).
Uses **Symfony2** module for testing. Includes

* Demo application from AcmoDemoBundle with session/redirection 
* simple CRUD application with Doctrine

Contribute to this application to introduce more sophisticated Symfony2 features and get them tested.
Tests located in [tests/functional](https://github.com/DavertMik/SymfonyCodeceptionApp/tree/master/tests/functional) directory

## Running Tests

* Install Codeception >= 2.0.3 (included in composer.json)
* Create database 

```
./app/console doctrine:database:create
```

* Create database schema

```
./app/console doctrine:schema:create
```

* Execute tests

```
./vendor/bin/codecept run
```

