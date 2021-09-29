<?php

declare(strict_types=1);

namespace Tests\Model\ItemVariants;

use GildedRose\Model\Item;
use GildedRose\Model\ItemVariants\AbstractItemVariant;
use GildedRose\Model\ItemVariants\AgedItem;
use Tests\AbstractTestCase;
use TypeError;

class AgedItemTest extends AbstractTestCase
{
    public function testCanNotConstructWithTypeError()
    {
        $input = $this->faker->randomElement([$this->faker->randomDigitNotNull, 2.5, true, false, 'foo']);

        $this->expectException(TypeError::class);

        $result = new AgedItem($input);
    }

    public function testCanUpdate()
    {
        $item = new Item(AgedItem::NAME, 5, 50);

        $actualItem = (new AgedItem($item))->update();

        $this->assertEquals(AgedItem::NAME, $actualItem->getName());
        $this->assertEquals(4, $actualItem->getSellIn());
        $this->assertEquals(50, $actualItem->getQuality());
    }

    public function testCanIncreaseOneQualityWithBelowHighestQuality()
    {
        $item = new Item(AgedItem::NAME, 5, 40);

        $actualItem = (new AgedItem($item))->update();

        $this->assertEquals(AgedItem::NAME, $actualItem->getName());
        $this->assertEquals(4, $actualItem->getSellIn());
        $this->assertEquals(41, $actualItem->getQuality());
    }

    public function testCanNotIncreaseOneQualityWithOverHighestQuality()
    {
        $item = new Item(AgedItem::NAME, 5, AbstractItemVariant::MAX_QUALITY);

        $actualItem = (new AgedItem($item))->update();

        $this->assertEquals(AgedItem::NAME, $actualItem->getName());
        $this->assertEquals(4, $actualItem->getSellIn());
        $this->assertEquals(AbstractItemVariant::MAX_QUALITY, $actualItem->getQuality());
    }

    public function testCanIncreaseTwoQualityWithBelowHighestQualityAndSellInNegative()
    {
        $item = new Item(AgedItem::NAME, -5, 40);

        $actualItem = (new AgedItem($item))->update();

        $this->assertEquals(AgedItem::NAME, $actualItem->getName());
        $this->assertEquals(-6, $actualItem->getSellIn());
        $this->assertEquals(42, $actualItem->getQuality());
    }

    public function testCanDecreaseOneSellIn()
    {
        $sellIn = $this->faker->randomDigitNotNull;

        $item = new Item(AgedItem::NAME, $sellIn, $this->faker->randomDigitNotNull);

        $actualItem = (new AgedItem($item))->update();

        $this->assertEquals(AgedItem::NAME, $actualItem->getName());
        $this->assertEquals($sellIn - 1, $actualItem->getSellIn());
    }
}
