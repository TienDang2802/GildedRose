<?php

declare(strict_types=1);

namespace GildedRose\Factories;

use GildedRose\Model\AbstractItemVariant;
use GildedRose\Model\Item;
use GildedRose\Model\ItemVariants\CommonItem;
use GildedRose\Utils\Str;

final class ItemVariantFactory
{
    public static function factory(Item $item): AbstractItemVariant
    {
        $className = sprintf(
            'GildedRose\\Model\\ItemVariants\\%sItem',
            ucfirst(Str::camel($item->getShortName()))
        );

        if (!class_exists($className)) {
            return new CommonItem($item);
        }

        return new $className($item);
    }
}
