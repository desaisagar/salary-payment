# Salary Payment Date tool

A command-line utility to generate a CSV file with the dates for salary payment to a sales department. There are two types of payments:

- Salary payment paid on the last day of the month unless that day is a Saturday or a Sunday (weekend).
- Bonus payment paid for the previous month, unless that day is a weekend. In that case, they are paid the first Wednesday after the 15th.

This project has the main objective to apply and study the following techniques:

- Test quality
- Writing an testable code
- Mocking
- Data fixtures
- Code coverage
- Test Organization

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisities

- [Composer](https://getcomposer.org/)
- [PHP 7](http://www.php.net/)

### Installing

Clone the repository

```
composer install
```

## Run application

```
php console.php <filename>.csv
```

## Run the tests

To run the PHPUnit tests at terminal or at command prompt:
```
./vendor/bin/phpunit
```

## Code coverage

To get code coverage run following command

```
./vendor/bin/phpunit --coverage-html <path/to/directory>
```

## Author

* **Sagar Desai** - [desaisagar](https://github.com/desaisagar)
