<?php

declare(strict_types=1);

namespace GildedRose\Model;

use GildedRose\Factories\ItemVariantFactory;

final class GildedRose
{
    /**
     * @var Item[]
     */
    private array $items;

    /**
     * @param array<Item> $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $k => $item) {
            if (!$item instanceof Item) {
                unset($this->items[$k]);

                continue;
            }

            (ItemVariantFactory::factory($item))->update();
        }
    }
}
