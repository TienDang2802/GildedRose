<p align="center">
    <img src="https://avatars.githubusercontent.com/u/5228734?s=200&v=4" width=200 />
</p>

<h1 align="center">Gilded Rose Refactoring Kata - PHP Version</h1>

This is my PHP solution to [Gilded Rose Refactoring Kata](https://github.com/emilybache/GildedRose-Refactoring-Kata/tree/main/php)

## Requirements

**PHP version**: 8.0 or greater

If you need environment to run, please use [Gilded Rose Docker for PHP Development](https://github.com/TienDang2802/GildedRoseVM)

## Table of Contents

1. [Dependencies](#Dependencies)
2. [Folders](#Folders)
3. [Usage](#Usage)
   - [Create Custom Item Variant](#create-custom-item-variant)
4. [Testing](#Testing)
5. [Code Standard](#code-standard)
6. [Check Code](#check-code)
7. [Fix Code](#fix-code)
8. [Static Analysis](#static-analysis)

## Dependencies

The project uses composer to install:

- [PHPUnit](https://phpunit.de/)
- [PHPStan](https://github.com/phpstan/phpstan)
- [Easy Coding Standard (ECS)](https://github.com/symplify/easy-coding-standard)
- [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer/wiki)
- [Nelmio fixtures generator](https://github.com/nelmio/alice)

## Folders

- `src` - contains the two classes:
    - `Model\Item.php` - this class should not be changed
    - `Model\GildedRose.php` - this class needs to be refactored, and the new feature added
    - `Model\ItemVariants\ItemVariants` - contains item variants classes
- `tests` - contains the tests
    - `GildedRoseTest.php` - starter test.
- `fixtures`
    - `item.yml` - Item Data Generation

## Usage

```php

<?php

use GildedRose\Model\GildedRose;
use GildedRose\Model\Item;
use GildedRose\Model\ItemVariants\SulfurasItem;

$items = [new Item(SulfurasItem::NAME, 10, 20)];
$gildedRose = new GildedRose($items);
/** 
 * Calculate quality & sell in base on formula function `update` of SulfurasItem
 * 
 * (fallback) If Item not exists, quality & sell in will be calculated on formula `update` of CommonItem.
 * 
 */
$gildedRose->updateQuality(); 

```

### Create Custom Item Variant

```php

<?php

namespace GildedRose\Model\ItemVariants;

use GildedRose\Model\Item;

/**
* Prefix Class name will get by Short name of Item.
* 
* E.g: 
* - Item name is `Custom name` => Class name is `CustomItem`
* - Item name is `+5 Dexterity Vest` => Class name is `DexterityItem`
* - Item name is `Elixir of the Mongoose` => Class name is `ElixirItem`
*/

final class CustomItem extends AbstractItemVariant
{
    public const NAME = 'Custom name';

    public function update(): Item
    {
        // do something ...

        return $this->item;
    }
}

```

## Testing

PHPUnit is configured for testing, a composer script has been provided. To run the unit tests, from the root of the PHP
project run:

```shell script
composer test
```

### Tests with Coverage Report

To run all test and generate a html coverage report run:

```shell script
composer test-coverage
```

The test-coverage report will be created in /builds, it is best viewed by opening /builds/**index.html** in your
browser.

## Code Standard

Easy Coding Standard (ECS) is configured for style and code standards, **PSR-12** is used.

> Config in `ecs.php`

### Check Code

To check code, but not fix errors:

```shell script
composer check-cs
```

### Fix Code

ECS provides may code fixes, automatically, if advised to run --fix, the following script can be run:

```shell script
composer fix-cs
```

## Static Analysis

PHPStan is used to run static analysis checks:

> Config in `phpstan.neon.dist`

```shell script
composer phpstan
```
