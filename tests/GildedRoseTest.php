<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Model\GildedRose;
use GildedRose\Model\Item;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\LoadItemData;
use Tests\Traits\WithFaker;

class GildedRoseTest extends AbstractTestCase
{
    protected array $fixtureItems;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixtureItems = (new LoadItemData())->loadData(__DIR__ . '/../fixtures/item.yml');
    }

    public function testWithInvalidItemInList()
    {
        $fixtureItems = $this->faker->randomElements(
            array_values($this->fixtureItems),
            2
        );

        $items = array_merge($fixtureItems, [$this->faker->name]);

        $this->assertEquals(3, count($items));

        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(2, count($gildedRose->getItems()));
    }

    public function testItemRandomNameAndHasQualityAndSellIn(): void
    {
        $itemName = $this->faker->name;
        $item = new Item($itemName, 10, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals($itemName, $actualItem->getName());
        $this->assertEquals(9, $actualItem->getSellIn());
        $this->assertEquals(19, $actualItem->getQuality());
    }

    public function testItemRandomNameAndHasQualityAndNotSellIn(): void
    {
        $itemName = $this->faker->name;
        $item = new Item($itemName, -1, 30);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals($itemName, $actualItem->getName());
        $this->assertEquals(-2, $actualItem->getSellIn());
        $this->assertEquals(28, $actualItem->getQuality());
    }

    public function testItemRandomNameAndHasEmptyQualityAndNotSellIn(): void
    {
        $itemName = $this->faker->name;
        $item = new Item($itemName, -1, 1);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals($itemName, $actualItem->getName());
        $this->assertEquals(-2, $actualItem->getSellIn());
        $this->assertEquals(0, $actualItem->getQuality());
    }

    public function testItemAgedBrieAndBelowMaxQualityAndHaveSellIn(): void
    {
        $item = new Item(Item::NAME_AGED_BRIE, 5, 40);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(Item::NAME_AGED_BRIE, $actualItem->getName());
        $this->assertEquals(4, $actualItem->getSellIn());
        $this->assertEquals(41, $actualItem->getQuality());
    }

    public function testItemAgedBrieAndBelowMaxQualityAndNotSellIn(): void
    {
        $item = new Item(Item::NAME_AGED_BRIE, -1, 40);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(Item::NAME_AGED_BRIE, $actualItem->getName());
        $this->assertEquals(-2, $actualItem->getSellIn());
        $this->assertEquals(42, $actualItem->getQuality());
    }

    public function testItemAgedBrieAndOverMaxQualityAndHaveSellIn(): void
    {
        $item = new Item(Item::NAME_AGED_BRIE, 5, 50);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(Item::NAME_AGED_BRIE, $actualItem->getName());
        $this->assertEquals(4, $actualItem->getSellIn());
        $this->assertEquals(50, $actualItem->getQuality());
    }

    public function testItemAgedBrieAndOverMaxQualityAndNotSellIn(): void
    {
        $item = new Item(Item::NAME_AGED_BRIE, -1, 50);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(Item::NAME_AGED_BRIE, $actualItem->getName());
        $this->assertEquals(-2, $actualItem->getSellIn());
        $this->assertEquals(50, $actualItem->getQuality());
    }

    public function testItemBackstageAndHasQualityAndBelowMinSellIn(): void
    {
        $item = new Item(Item::NAME_BACKSTAGE, 5, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(Item::NAME_BACKSTAGE, $actualItem->getName());
        $this->assertEquals(4, $actualItem->getSellIn());
        $this->assertEquals(23, $actualItem->getQuality());
    }

    public function testItemBackstageAndHasQualityAndInRangeSellIn(): void
    {
        $item = new Item(Item::NAME_BACKSTAGE, 8, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(Item::NAME_BACKSTAGE, $actualItem->getName());
        $this->assertEquals(7, $actualItem->getSellIn());
        $this->assertEquals(22, $actualItem->getQuality());
    }

    public function testItemBackstageAndHasQualityAndOverMaxSellIn(): void
    {
        $item = new Item(Item::NAME_BACKSTAGE, 11, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(Item::NAME_BACKSTAGE, $actualItem->getName());
        $this->assertEquals(10, $actualItem->getSellIn());
        $this->assertEquals(21, $actualItem->getQuality());
    }

    public function testItemBackstageAndOverQualityAndHasSellIn(): void
    {
        $sellIn = $this->faker->randomDigitNotNull;

        $item = new Item(Item::NAME_BACKSTAGE, $sellIn, 50);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(Item::NAME_BACKSTAGE, $actualItem->getName());
        $this->assertEquals($sellIn - 1, $actualItem->getSellIn());
        $this->assertEquals(50, $actualItem->getQuality());
    }

    public function testItemBackstageAndOverQualityAndNotSellIn(): void
    {
        $item = new Item(Item::NAME_BACKSTAGE, 0, 50);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(Item::NAME_BACKSTAGE, $actualItem->getName());
        $this->assertEquals(-1, $actualItem->getSellIn());
        $this->assertEquals(0, $actualItem->getQuality());
    }

    public function testItemSulfurasAndHasQualityAndSellIn(): void
    {
        $item = new Item(Item::NAME_SULFURAS, 10, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(Item::NAME_SULFURAS, $actualItem->getName());
        $this->assertEquals(10, $actualItem->getSellIn());
        $this->assertEquals(20, $actualItem->getQuality());
    }

    public function testItemSulfurasAndBelowMaxQualityAndNotSellIn(): void
    {
        $item = new Item(Item::NAME_SULFURAS, 0, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(Item::NAME_SULFURAS, $actualItem->getName());
        $this->assertEquals(0, $actualItem->getSellIn());
        $this->assertEquals(20, $actualItem->getQuality());
    }
}
