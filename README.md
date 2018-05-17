Custom PHP-CS-Fixer Rule
========================

This is an example implementation of the custom PHP-CS-Fixer
rule.


Installation
------------

Run `composer install` or `composer update`.


Usage
-----

Run `composer fix` to reset the source files and apply the
custom rule.


Testing
-------

Run `composer test` to check if the custom rule produced the
expected result.


Under The Hood
--------------

Here's how this whole thing works:

1. The command `composer fix` is defined as a composer script
   inside the `composer.json` file.  It does the following:
   * Copy (with overwrite) the file from `tests/data/Original.php`
     to `src/File.php`.
   * Execute PHP-CS-Fixer with the `fix` command, using the
     configuration provided in `.php_cs.dist` file.
2. PHP-CS-Fixer configuration sets only a single rule to be
   used for the run.  That rule is a custom fixer, which lives
   in `config/` folder.  The rule file is modified from another
   rule - `NoUnreachableDefaultArgumentValueFixer`, which is a
   part of the PHP-CS-Fixer distribution.
3. PHP-CS-Fixer runs and modifies all file PHP files in the `src/`
   folder.

For easier testing, PHPUnit is setup in the `tests/` folder.  It runs
like so:

1. The command `composer test` is defined as composer script inside
   the `composer.json` file.  It simply runs PHPUnit with the `tests/`
   as test location parameter.
2. Example test file consists of two tests:
   1. Basic test with a single assertion for the true=true.
   2. File test, which makes sure that resulting file exists in
      the `src/` folder, that expected file exists in `tests/data`
	  folder, and that the content of these two files is the same.


