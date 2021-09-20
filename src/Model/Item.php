<?php

declare(strict_types=1);

namespace GildedRose\Model;

final class Item
{
    const NAME_AGED_BRIE = 'Aged Brie';

    const NAME_BACKSTAGE = 'Backstage passes to a TAFKAL80ETC concert';

    const NAME_SULFURAS = 'Sulfuras, Hand of Ragnaros';

    private string $name;

    private int $sellIn;

    private int $quality;

    /**
     * Constructor property promotion
     *
     * @link https://www.php.net/releases/8.0/en.php#constructor-property-promotion
     */
    public function __construct(string $name, int $sellIn, int $quality)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSellIn(): int
    {
        return $this->sellIn;
    }

    public function setSellIn(int $sellIn): self
    {
        $this->sellIn = $sellIn;

        return $this;
    }

    public function getQuality(): int
    {
        return $this->quality;
    }

    public function setQuality(int $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function hasName(string $name): bool
    {
        return $this->name === $name;
    }

    public function increaseQuality(int $quality = 1): self
    {
        $this->quality += $quality;

        return $this;
    }

    public function decreaseQuality(int $quality = 1): self
    {
        $this->quality -= $quality;

        return $this;
    }

    public function clearQuality(): self
    {
        $this->quality = 0;

        return $this;
    }

    public function decreaseSellIn(int $sellIn = 1): self
    {
        $this->sellIn -= $sellIn;

        return $this;
    }

    public function isSellIn(): bool
    {
        return $this->sellIn >= 0;
    }

    public function __toString(): string
    {
        return sprintf('%s, %s, %s', $this->name, $this->sellIn, $this->quality);
    }
}
