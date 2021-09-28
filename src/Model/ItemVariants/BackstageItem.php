<?php

declare(strict_types=1);

namespace GildedRose\Model\ItemVariants;

use GildedRose\Model\Item;

final class BackstageItem extends AbstractItemVariant
{
    public const NAME = 'Backstage passes to a TAFKAL80ETC concert';

    public function update(): Item
    {
        if (!$this->hasReachedHighestQuality()) {
            $this->item->increaseQuality();

            $sellIn = $this->item->getSellIn();

            if ($sellIn < self::RANGE_SELL_IN_BELOW_11 && !$this->hasReachedHighestQuality()) {
                $this->item->increaseQuality();
            }

            if ($sellIn < self::RANGE_SELL_IN_BELOW_6 && !$this->hasReachedHighestQuality()) {
                $this->item->increaseQuality();
            }
        }

        $this->item->decreaseSellIn();

        if ($this->isSellInNegative()) {
            $this->item->clearQuality();
        }

        return $this->item;
    }
}
