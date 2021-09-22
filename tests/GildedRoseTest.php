<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Model\GildedRose;
use GildedRose\Model\Item;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\LoadItemData;

class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {
        //$a = (new LoadItemData())->loadData(__DIR__ . '/../fixtures/item.yml');

        $items = [new Item('foo', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->getName());
    }
}
