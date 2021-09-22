<?php

require '../vendor/autoload.php';

use GildedRose\Model\GildedRose;
use GildedRose\Model\Item;

$items = [new Item('foo', 0, 0)];
$gildedRose = new GildedRose($items);
$gildedRose->updateQuality();
