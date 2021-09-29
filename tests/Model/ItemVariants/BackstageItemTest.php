<?php

declare(strict_types=1);

namespace Tests\Model\ItemVariants;

use GildedRose\Model\Item;
use GildedRose\Model\ItemVariants\AgedItem;
use GildedRose\Model\ItemVariants\BackstageItem;
use Tests\AbstractTestCase;
use TypeError;

class BackstageItemTest extends AbstractTestCase
{
    public function testCanNotConstructWithTypeError()
    {
        $input = $this->faker->randomElement([$this->faker->randomDigitNotNull, 2.5, true, false, 'foo']);

        $this->expectException(TypeError::class);

        $result = new BackstageItem($input);
    }

    public function testCanUpdate()
    {
        $item = new Item(BackstageItem::NAME, 5, 20);

        $actualItem = (new BackstageItem($item))->update();

        $this->assertEquals(BackstageItem::NAME, $actualItem->getName());
        $this->assertEquals(4, $actualItem->getSellIn());
        $this->assertEquals(23, $actualItem->getQuality());
    }

    public function testCanIncreaseOneQualityWithBelowHighestQualityAndOverMaxSellIn()
    {
        $item = new Item(BackstageItem::NAME, 25, 40);

        $actualItem = (new BackstageItem($item))->update();

        $this->assertEquals(BackstageItem::NAME, $actualItem->getName());
        $this->assertEquals(24, $actualItem->getSellIn());
        $this->assertEquals(41, $actualItem->getQuality());
    }

    public function testCanIncreaseTwoQualityWithBelowHighestQualityAndInRangeSellIn()
    {
        $item = new Item(BackstageItem::NAME, 9, 40);

        $actualItem = (new BackstageItem($item))->update();

        $this->assertEquals(BackstageItem::NAME, $actualItem->getName());
        $this->assertEquals(8, $actualItem->getSellIn());
        $this->assertEquals(42, $actualItem->getQuality());
    }

    public function testCanIncreaseThreeQualityWithBelowHighestQualityAndBelowMinSellIn()
    {
        $item = new Item(BackstageItem::NAME, 5, 40);

        $actualItem = (new BackstageItem($item))->update();

        $this->assertEquals(BackstageItem::NAME, $actualItem->getName());
        $this->assertEquals(4, $actualItem->getSellIn());
        $this->assertEquals(43, $actualItem->getQuality());
    }

    public function testCanClearQualityWithSellInNegative()
    {
        $item = new Item(BackstageItem::NAME, -5, $this->faker->randomDigitNotNull);

        $actualItem = (new BackstageItem($item))->update();

        $this->assertEquals(BackstageItem::NAME, $actualItem->getName());
        $this->assertEquals(-6, $actualItem->getSellIn());
        $this->assertEquals(0, $actualItem->getQuality());
    }

    public function testCanDecreaseOneSellIn()
    {
        $sellIn = $this->faker->randomDigitNotNull;

        $item = new Item(BackstageItem::NAME, $sellIn, $this->faker->randomDigitNotNull);

        $actualItem = (new BackstageItem($item))->update();

        $this->assertEquals(BackstageItem::NAME, $actualItem->getName());
        $this->assertEquals($sellIn - 1, $actualItem->getSellIn());
    }
}
