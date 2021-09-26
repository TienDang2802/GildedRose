<?php

declare(strict_types=1);

namespace GildedRose\Model\ItemVariants;

use GildedRose\Model\AbstractItemVariant;
use GildedRose\Model\Item;

final class SulfurasItem extends AbstractItemVariant
{
    public const NAME = 'Sulfuras, Hand of Ragnaros';

    public function update(): Item
    {
        return $this->item;
    }
}
