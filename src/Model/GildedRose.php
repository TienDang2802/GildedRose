<?php

declare(strict_types=1);

namespace GildedRose\Model;

final class GildedRose
{
    /**
     * @var Item[]
     */
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if ($item->getName() != 'Aged Brie' and $item->getName() != 'Backstage passes to a TAFKAL80ETC concert') {
                if ($item->getQuality() > 0) {
                    if ($item->getName() != 'Sulfuras, Hand of Ragnaros') {
                        $item->decreaseQuality();
                    }
                }
            } else {
                if ($item->getQuality() < 50) {
                    $item->increaseQuality();
                    if ($item->getName() == 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->sell_in < 11) {
                            if ($item->getQuality() < 50) {
                                $item->increaseQuality();
                            }
                        }
                        if ($item->sell_in < 6) {
                            if ($item->getQuality() < 50) {
                                $item->increaseQuality();
                            }
                        }
                    }
                }
            }

            if ($item->getName() != 'Sulfuras, Hand of Ragnaros') {
                $item->sell_in = $item->sell_in - 1;
            }

            if ($item->getSellIn() < 0) {
                if ($item->getName() != 'Aged Brie') {
                    if ($item->getName() != 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->getQuality() > 0) {
                            if ($item->getName() != 'Sulfuras, Hand of Ragnaros') {
                                $item->decreaseQuality();
                            }
                        }
                    } else {
                        $item->clearQuality();
                    }
                } else {
                    if ($item->getQuality() < 50) {
                        $item->increaseQuality();
                    }
                }
            }
        }
    }
}
