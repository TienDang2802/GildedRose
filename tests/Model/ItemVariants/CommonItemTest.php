<?php

declare(strict_types=1);

namespace Tests\Model\ItemVariants;

use GildedRose\Model\Item;
use GildedRose\Model\ItemVariants\CommonItem;
use Tests\AbstractTestCase;
use TypeError;

class CommonItemTest extends AbstractTestCase
{
    public function testCanNotConstructWithTypeError()
    {
        $input = $this->faker->randomElement([$this->faker->randomDigitNotNull, 2.5, true, false, 'foo']);

        $this->expectException(TypeError::class);

        $result = new CommonItem($input);
    }

    public function testCanUpdate()
    {
        $itemName = $this->faker->name;
        $item = new Item($itemName, 10, 20);

        $actualItem = (new CommonItem($item))->update();

        $this->assertEquals($itemName, $actualItem->getName());
        $this->assertEquals(9, $actualItem->getSellIn());
        $this->assertEquals(19, $actualItem->getQuality());
    }

    public function testDecreaseOneQualityWithQualityOverZero()
    {
        $itemName = $this->faker->name;
        $quality = $this->faker->randomDigitNotNull;
        $sellIn = $this->faker->randomDigitNotNull;

        $item = new Item($itemName, $sellIn, $quality);

        $actualItem = (new CommonItem($item))->update();

        $this->assertEquals($itemName, $actualItem->getName());
        $this->assertEquals($quality - 1, $actualItem->getQuality());
    }

    public function testDecreaseTwoQualityWithQualityOverZeroAndSellInNegative()
    {
        $itemName = $this->faker->name;
        $quality = $this->faker->randomDigitNotNull;

        $item = new Item($itemName, -1, $quality);

        $actualItem = (new CommonItem($item))->update();

        $this->assertEquals($itemName, $actualItem->getName());
        $this->assertEquals($quality - 2, $actualItem->getQuality());
    }

    public function testCanDecreaseOneSellIn()
    {
        $itemName = $this->faker->name;
        $sellIn = $this->faker->randomDigitNotNull;

        $item = new Item($itemName, $sellIn, $this->faker->randomDigitNotNull);

        $actualItem = (new CommonItem($item))->update();

        $this->assertEquals($itemName, $actualItem->getName());
        $this->assertEquals($sellIn - 1, $actualItem->getSellIn());
    }
}
