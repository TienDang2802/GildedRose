<?php

declare(strict_types=1);

namespace GildedRose\Model\ItemVariants;

use GildedRose\Model\AbstractItemVariant;
use GildedRose\Model\Item;

class CommonItem extends AbstractItemVariant
{
    public function update(): Item
    {
        if ($this->item->getQuality() > 0) {
            $this->item->decreaseQuality();
        }

        $this->item->decreaseSellIn();

        if ($this->isSellInLtZero() && $this->item->getQuality() > 0) {
            $this->item->decreaseQuality();
        }

        return $this->item;
    }
}
