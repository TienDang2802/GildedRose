<?php

declare(strict_types=1);

namespace Tests\Factories;

use GildedRose\Factories\ItemVariantFactory;
use GildedRose\Model\Item;
use GildedRose\Model\ItemVariants\AgedItem;
use GildedRose\Model\ItemVariants\BackstageItem;
use GildedRose\Model\ItemVariants\CommonItem;
use GildedRose\Model\ItemVariants\SulfurasItem;
use Tests\AbstractTestCase;
use TypeError;

class ItemVariantFactoryTest extends AbstractTestCase
{
    public function testCanNotFactoryWithTypeError()
    {
        $input = $this->faker->randomElement([2, 2.5, true, false, 'foo']);

        $this->expectException(TypeError::class);

        ItemVariantFactory::factory($input);
    }

    public function testCanFactoryCreateAgedItem()
    {
        $item = new Item(AgedItem::NAME, $this->faker->randomDigitNotNull, $this->faker->randomDigitNotNull);

        $result = ItemVariantFactory::factory($item);

        $this->assertInstanceOf(AgedItem::class, $result);
    }

    public function testCanFactoryCreateBackstageItem()
    {
        $item = new Item(BackstageItem::NAME, $this->faker->randomDigitNotNull, $this->faker->randomDigitNotNull);

        $result = ItemVariantFactory::factory($item);

        $this->assertInstanceOf(BackstageItem::class, $result);
    }

    public function testCanFactoryCreateSulfurasItem()
    {
        $item = new Item(SulfurasItem::NAME, $this->faker->randomDigitNotNull, $this->faker->randomDigitNotNull);

        $result = ItemVariantFactory::factory($item);

        $this->assertInstanceOf(SulfurasItem::class, $result);
    }

    public function testCanFactoryFallbackCommonItem()
    {
        $item = new Item($this->faker->name, $this->faker->randomDigitNotNull, $this->faker->randomDigitNotNull);

        $result = ItemVariantFactory::factory($item);

        $this->assertInstanceOf(CommonItem::class, $result);
    }
}
