<?php

declare(strict_types=1);

namespace GildedRose\Model\ItemVariants;

use GildedRose\Model\Item;

final class AgedItem extends AbstractItemVariant
{
    public const NAME = 'Aged Brie';

    public function update(): Item
    {
        if (!$this->hasReachedHighestQuality()) {
            $this->item->increaseQuality();
        }

        $this->item->decreaseSellIn();

        if ($this->isSellInNegative() && !$this->hasReachedHighestQuality()) {
            $this->item->increaseQuality();
        }

        return $this->item;
    }
}
