<?php

require '../vendor/autoload.php';

use GildedRose\Model\GildedRose;
use GildedRose\Model\Item;
use GildedRose\Model\ItemVariants\SulfurasItem;

$items = [new Item(SulfurasItem::NAME, 10, 20)];
$gildedRose = new GildedRose($items);
$gildedRose->updateQuality();
