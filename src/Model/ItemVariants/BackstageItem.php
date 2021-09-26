<?php

declare(strict_types=1);

namespace GildedRose\Model\ItemVariants;

use GildedRose\Model\AbstractItemVariant;
use GildedRose\Model\Item;

final class BackstageItem extends AbstractItemVariant
{
    public const NAME = 'Backstage passes to a TAFKAL80ETC concert';

    public function update(): Item
    {
        $quality = $this->item->getQuality();

        if ($quality < self::MAX_QUALITY) {
            $quality++;

            $sellIn = $this->item->getSellIn();

            if ($sellIn < self::RANGE_SELL_IN_BELOW_11 && $quality < self::MAX_QUALITY) {
                $quality++;
            }

            if ($sellIn < self::RANGE_SELL_IN_BELOW_6 && $quality < self::MAX_QUALITY) {
                $quality++;
            }

            $this->item->setQuality($quality);
        }

        $this->item->decreaseSellIn();

        if ($this->isSellInLtZero()) {
            $this->item->clearQuality();
        }

        return $this->item;
    }
}
