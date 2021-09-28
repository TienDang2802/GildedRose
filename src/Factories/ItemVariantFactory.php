<?php

declare(strict_types=1);

namespace GildedRose\Factories;

use GildedRose\Model\Item;
use GildedRose\Model\ItemVariants\AbstractItemVariant;
use GildedRose\Model\ItemVariants\CommonItem;
use GildedRose\Utils\Str;

final class ItemVariantFactory
{
    private static array $subscribers = [];

    public static function factory(Item $item): AbstractItemVariant
    {
        if (!isset(self::$subscribers[$item->getShortName()])) {
            $namespaceClass = sprintf(
                '%s\\%sItem',
                (new \ReflectionClass(AbstractItemVariant::class))->getNamespaceName(),
                ucfirst(Str::camel($item->getShortName()))
            );

            self::$subscribers[$item->getShortName()] = $namespaceClass;
        } else {
            $namespaceClass = self::$subscribers[$item->getShortName()];
        }

        try {
            $reflection = new \ReflectionClass($namespaceClass);

            return $reflection->newInstanceArgs([$item]);
        } catch (\ReflectionException $e) {
            return new CommonItem($item);
        }
    }
}
