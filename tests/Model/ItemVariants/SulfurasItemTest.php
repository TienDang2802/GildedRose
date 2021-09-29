<?php

declare(strict_types=1);

namespace Tests\Model\ItemVariants;

use GildedRose\Model\Item;
use GildedRose\Model\ItemVariants\AgedItem;
use GildedRose\Model\ItemVariants\SulfurasItem;
use Tests\AbstractTestCase;
use TypeError;

class SulfurasItemTest extends AbstractTestCase
{
    public function testCanNotConstructWithTypeError()
    {
        $input = $this->faker->randomElement([$this->faker->randomDigitNotNull, 2.5, true, false, 'foo']);

        $this->expectException(TypeError::class);

        $result = new SulfurasItem($input);
    }

    public function testCanUpdate()
    {
        $item = new Item(SulfurasItem::NAME, 10, 20);

        $actualItem = (new SulfurasItem($item))->update();

        $this->assertEquals(SulfurasItem::NAME, $actualItem->getName());
        $this->assertEquals(10, $actualItem->getSellIn());
        $this->assertEquals(20, $actualItem->getQuality());
    }

    public function testNotChangeWithAnyValueQualityAndSellIn()
    {
        $sellIn = $this->faker->randomDigitNotNull;
        $quality = $this->faker->randomDigitNotNull;

        $item = new Item(SulfurasItem::NAME, $sellIn, $quality);

        $actualItem = (new SulfurasItem($item))->update();

        $this->assertEquals(SulfurasItem::NAME, $actualItem->getName());
        $this->assertEquals($sellIn, $actualItem->getSellIn());
        $this->assertEquals($quality, $actualItem->getQuality());
    }
}
