<?php

declare(strict_types=1);

namespace GildedRose\Model\ItemVariants;

use GildedRose\Model\Item;

abstract class AbstractItemVariant
{
    public const MAX_QUALITY = 50;

    public const RANGE_SELL_IN_BELOW_11 = 11;

    public const RANGE_SELL_IN_BELOW_6 = 6;

    public function __construct(protected Item $item)
    {
    }

    protected function hasReachedHighestQuality(): bool
    {
        return $this->item->getQuality() >= self::MAX_QUALITY;
    }

    protected function isSellInNegative(): bool
    {
        return $this->item->getSellIn() < 0;
    }

    abstract public function update(): Item;
}
