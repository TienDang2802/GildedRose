<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Model\GildedRose;
use GildedRose\Model\Item;
use GildedRose\Model\ItemVariants\AgedItem;
use GildedRose\Model\ItemVariants\BackstageItem;
use GildedRose\Model\ItemVariants\SulfurasItem;
use Tests\Fixtures\LoadItemData;

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

    public function testCommonItemAndHasQualityAndSellIn(): void
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

    public function testCommonItemAndHasQualityAndNotSellIn(): void
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

    public function testCommonItemAndHasEmptyQualityAndNotSellIn(): void
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
        $item = new Item(AgedItem::NAME, 5, 40);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(AgedItem::NAME, $actualItem->getName());
        $this->assertEquals(4, $actualItem->getSellIn());
        $this->assertEquals(41, $actualItem->getQuality());
    }

    public function testItemAgedBrieAndBelowMaxQualityAndNotSellIn(): void
    {
        $item = new Item(AgedItem::NAME, -1, 40);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(AgedItem::NAME, $actualItem->getName());
        $this->assertEquals(-2, $actualItem->getSellIn());
        $this->assertEquals(42, $actualItem->getQuality());
    }

    public function testItemAgedBrieAndOverMaxQualityAndHaveSellIn(): void
    {
        $item = new Item(AgedItem::NAME, 5, 50);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(AgedItem::NAME, $actualItem->getName());
        $this->assertEquals(4, $actualItem->getSellIn());
        $this->assertEquals(50, $actualItem->getQuality());
    }

    public function testItemAgedBrieAndOverMaxQualityAndNotSellIn(): void
    {
        $item = new Item(AgedItem::NAME, -1, 50);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(AgedItem::NAME, $actualItem->getName());
        $this->assertEquals(-2, $actualItem->getSellIn());
        $this->assertEquals(50, $actualItem->getQuality());
    }

    public function testItemBackstageAndHasQualityAndBelowMinSellIn(): void
    {
        $item = new Item(BackstageItem::NAME, 5, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(BackstageItem::NAME, $actualItem->getName());
        $this->assertEquals(4, $actualItem->getSellIn());
        $this->assertEquals(23, $actualItem->getQuality());
    }

    public function testItemBackstageAndHasQualityAndInRangeSellIn(): void
    {
        $item = new Item(BackstageItem::NAME, 8, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(BackstageItem::NAME, $actualItem->getName());
        $this->assertEquals(7, $actualItem->getSellIn());
        $this->assertEquals(22, $actualItem->getQuality());
    }

    public function testItemBackstageAndHasQualityAndOverMaxSellIn(): void
    {
        $item = new Item(BackstageItem::NAME, 11, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(BackstageItem::NAME, $actualItem->getName());
        $this->assertEquals(10, $actualItem->getSellIn());
        $this->assertEquals(21, $actualItem->getQuality());
    }

    public function testItemBackstageAndOverQualityAndHasSellIn(): void
    {
        $sellIn = $this->faker->randomDigitNotNull;

        $item = new Item(BackstageItem::NAME, $sellIn, 50);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(BackstageItem::NAME, $actualItem->getName());
        $this->assertEquals($sellIn - 1, $actualItem->getSellIn());
        $this->assertEquals(50, $actualItem->getQuality());
    }

    public function testItemBackstageAndOverQualityAndNotSellIn(): void
    {
        $item = new Item(BackstageItem::NAME, 0, 50);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(BackstageItem::NAME, $actualItem->getName());
        $this->assertEquals(-1, $actualItem->getSellIn());
        $this->assertEquals(0, $actualItem->getQuality());
    }

    public function testItemSulfurasAndHasQualityAndSellIn(): void
    {
        $item = new Item(SulfurasItem::NAME, 10, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(SulfurasItem::NAME, $actualItem->getName());
        $this->assertEquals(10, $actualItem->getSellIn());
        $this->assertEquals(20, $actualItem->getQuality());
    }

    public function testItemSulfurasAndBelowMaxQualityAndNotSellIn(): void
    {
        $item = new Item(SulfurasItem::NAME, 0, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $actualItem = $gildedRose->getItems()[0];

        $this->assertEquals(SulfurasItem::NAME, $actualItem->getName());
        $this->assertEquals(0, $actualItem->getSellIn());
        $this->assertEquals(20, $actualItem->getQuality());
    }

    public function testMixItems(): void
    {
        $items = [
            new Item(BackstageItem::NAME, 5, 20),
            new Item(AgedItem::NAME, 5, 40),
            new Item(SulfurasItem::NAME, 10, 20)
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $backstageItem = $gildedRose->getItems()[0];
        $this->assertEquals(BackstageItem::NAME, $backstageItem->getName());
        $this->assertEquals(4, $backstageItem->getSellIn());
        $this->assertEquals(23, $backstageItem->getQuality());

        $agedItem = $gildedRose->getItems()[1];
        $this->assertEquals(AgedItem::NAME, $agedItem->getName());
        $this->assertEquals(4, $agedItem->getSellIn());
        $this->assertEquals(41, $agedItem->getQuality());


        $sulfurasItem = $gildedRose->getItems()[2];
        $this->assertEquals(SulfurasItem::NAME, $sulfurasItem->getName());
        $this->assertEquals(10, $sulfurasItem->getSellIn());
        $this->assertEquals(20, $sulfurasItem->getQuality());
    }

    public function testMixItemsWithDataFixtures(): void
    {
        $items = [
           $this->fixtureItems['itemBackstage_fixture'],
           $this->fixtureItems['itemAged_fixture'],
           $this->fixtureItems['itemSulfuras_fixture'],
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $backstageItem = $gildedRose->getItems()[0];
        $this->assertEquals(BackstageItem::NAME, $backstageItem->getName());
        $this->assertEquals(4, $backstageItem->getSellIn());
        $this->assertEquals(23, $backstageItem->getQuality());

        $agedItem = $gildedRose->getItems()[1];
        $this->assertEquals(AgedItem::NAME, $agedItem->getName());
        $this->assertEquals(4, $agedItem->getSellIn());
        $this->assertEquals(41, $agedItem->getQuality());


        $sulfurasItem = $gildedRose->getItems()[2];
        $this->assertEquals(SulfurasItem::NAME, $sulfurasItem->getName());
        $this->assertEquals(10, $sulfurasItem->getSellIn());
        $this->assertEquals(20, $sulfurasItem->getQuality());
    }
}
