<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Model\Item;

class ItemTest extends AbstractTestCase
{
    public function testCanCastToString()
    {
        $itemName = $this->faker->name;

        $item = new Item($itemName, 10, 20);

        $this->assertEquals($itemName . ', 10, 20', (string)$item);
    }

    public function testGetAndSetterName()
    {
        $item = new Item('foo', 10, 20);

        $this->assertEquals('foo', $item->getName());

        $itemName = $this->faker->name;
        $item->setName($itemName);
        $this->assertEquals($itemName, $item->getName());
    }

    public function testGetAndSetterSellIn()
    {
        $item = new Item('foo', 10, 20);

        $this->assertEquals(10, $item->getSellIn());

        $itemSellIn = $this->faker->randomDigitNotNull;
        $item->setSellIn($itemSellIn);
        $this->assertEquals($itemSellIn, $item->getSellIn());
    }

    public function testGetAndSetterQuality()
    {
        $item = new Item('foo', 10, 20);

        $this->assertEquals(20, $item->getQuality());

        $itemQuality = $this->faker->randomDigitNotNull;
        $item->setQuality($itemQuality);
        $this->assertEquals($itemQuality, $item->getQuality());
    }

    public function testCanIncreaseOrDecreaseAndClearQuality()
    {
        $item = new Item('foo', 10, 20);

        $this->assertEquals(20, $item->getQuality());

        $item->increaseQuality();
        $this->assertEquals(21, $item->getQuality());

        $item->increaseQuality(9);
        $this->assertEquals(30, $item->getQuality());

        $item->decreaseQuality();
        $this->assertEquals(29, $item->getQuality());

        $item->decreaseQuality(20);
        $this->assertEquals(9, $item->getQuality());

        $item->clearQuality();
        $this->assertEquals(0, $item->getQuality());
    }
}
