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

    public function testMultiAgedBrieItems()
    {
        $item1 = new Item(AgedItem::NAME, -1, 40);
        $item2 = new Item(AgedItem::NAME, 5, 50);
        $item3 = new Item(AgedItem::NAME, -1, 50);

        $gildedRose = new GildedRose([$item1, $item2, $item3]);
        $gildedRose->updateQuality();

        $actualItem1 = $gildedRose->getItems()[0];
        $this->assertEquals(AgedItem::NAME, $actualItem1->getName());
        $this->assertEquals(-2, $actualItem1->getSellIn());
        $this->assertEquals(42, $actualItem1->getQuality());

        $actualItem2 = $gildedRose->getItems()[1];
        $this->assertEquals(AgedItem::NAME, $actualItem2->getName());
        $this->assertEquals(4, $actualItem2->getSellIn());
        $this->assertEquals(50, $actualItem2->getQuality());

        $actualItem3 = $gildedRose->getItems()[2];
        $this->assertEquals(AgedItem::NAME, $actualItem3->getName());
        $this->assertEquals(-2, $actualItem3->getSellIn());
        $this->assertEquals(50, $actualItem3->getQuality());
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

    public function testMultiBackstageItems()
    {
        $item1 = new Item(BackstageItem::NAME, 5, 20);
        $item2 = new Item(BackstageItem::NAME, 8, 20);
        $item3 = new Item(BackstageItem::NAME, 11, 20);

        $gildedRose = new GildedRose([$item1, $item2, $item3]);
        $gildedRose->updateQuality();

        $actualItem1 = $gildedRose->getItems()[0];

        $this->assertEquals(BackstageItem::NAME, $actualItem1->getName());
        $this->assertEquals(4, $actualItem1->getSellIn());
        $this->assertEquals(23, $actualItem1->getQuality());

        $actualItem2 = $gildedRose->getItems()[1];

        $this->assertEquals(BackstageItem::NAME, $actualItem2->getName());
        $this->assertEquals(7, $actualItem2->getSellIn());
        $this->assertEquals(22, $actualItem2->getQuality());

        $actualItem3 = $gildedRose->getItems()[2];

        $this->assertEquals(BackstageItem::NAME, $actualItem3->getName());
        $this->assertEquals(10, $actualItem3->getSellIn());
        $this->assertEquals(21, $actualItem3->getQuality());
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

    public function testMultiSulfurasItem()
    {
        $item1 = new Item(SulfurasItem::NAME, 10, 20);
        $item2 = new Item(SulfurasItem::NAME, 0, 20);

        $gildedRose = new GildedRose([$item1, $item2]);
        $gildedRose->updateQuality();

        $actualItem1 = $gildedRose->getItems()[0];

        $this->assertEquals(SulfurasItem::NAME, $actualItem1->getName());
        $this->assertEquals(10, $actualItem1->getSellIn());
        $this->assertEquals(20, $actualItem1->getQuality());

        $actualItem2 = $gildedRose->getItems()[1];

        $this->assertEquals(SulfurasItem::NAME, $actualItem2->getName());
        $this->assertEquals(0, $actualItem2->getSellIn());
        $this->assertEquals(20, $actualItem2->getQuality());
    }

    public function testMixItems(): void
    {
        $itemCustomName = $this->faker->name;

        $items = [
            new Item(BackstageItem::NAME, 5, 20),
            new Item(AgedItem::NAME, 5, 40),
            new Item(SulfurasItem::NAME, 10, 20),
            new Item($itemCustomName, 10, 20)
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

        $customItem = $gildedRose->getItems()[3];
        $this->assertEquals($itemCustomName, $customItem->getName());
        $this->assertEquals(9, $customItem->getSellIn());
        $this->assertEquals(19, $customItem->getQuality());
    }

    public function testMixItemsWithDataFixtures(): void
    {
        $items = [
           $this->fixtureItems['itemBackstage_fixture'],
           $this->fixtureItems['itemAged_fixture'],
           $this->fixtureItems['itemSulfuras_fixture'],
           $this->fixtureItems['itemAgedSellInGtZero_fixture'],
           $this->fixtureItems['itemBackstageOverMaxQuality_fixture'],
           $this->fixtureItems['itemBackstageSellInGtZeroAndOverMaxQuality_fixture'],
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $backstageItem = $gildedRose->getItems()[0];
        $this->assertEquals(BackstageItem::NAME, $backstageItem->getName());
        $this->assertEquals(5, $backstageItem->getSellIn());
        $this->assertEquals(24, $backstageItem->getQuality());

        $agedItem = $gildedRose->getItems()[1];
        $this->assertEquals(AgedItem::NAME, $agedItem->getName());
        $this->assertEquals(9, $agedItem->getSellIn());
        $this->assertEquals(33, $agedItem->getQuality());


        $sulfurasItem = $gildedRose->getItems()[2];
        $this->assertEquals(SulfurasItem::NAME, $sulfurasItem->getName());
        $this->assertEquals(8, $sulfurasItem->getSellIn());
        $this->assertEquals(39, $sulfurasItem->getQuality());

        $agedSellInGtZeroItem = $gildedRose->getItems()[3];
        $this->assertEquals(AgedItem::NAME, $agedSellInGtZeroItem->getName());
        $this->assertEquals(-2, $agedSellInGtZeroItem->getSellIn());
        $this->assertEquals(10, $agedSellInGtZeroItem->getQuality());

        $backstageOverMaxQualityItem = $gildedRose->getItems()[4];
        $this->assertEquals(BackstageItem::NAME, $backstageOverMaxQualityItem->getName());
        $this->assertEquals(10, $backstageOverMaxQualityItem->getSellIn());
        $this->assertEquals(102, $backstageOverMaxQualityItem->getQuality());

        $backstageSellInGtZeroAndOverMaxQualityItem = $gildedRose->getItems()[5];
        $this->assertEquals(BackstageItem::NAME, $backstageSellInGtZeroAndOverMaxQualityItem->getName());
        $this->assertEquals(-10, $backstageSellInGtZeroAndOverMaxQualityItem->getSellIn());
        $this->assertEquals(0, $backstageSellInGtZeroAndOverMaxQualityItem->getQuality());
    }
}
