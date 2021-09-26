<?php

declare(strict_types=1);

namespace GildedRose\Utils;

final class Str
{
    public static function studly(string $value): string
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return str_replace(' ', '', $value);
    }

    public static function camel(string $value): string
    {
        return lcfirst(self::studly($value));
    }
}
