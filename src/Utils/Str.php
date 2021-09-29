<?php

declare(strict_types=1);

namespace GildedRose\Utils;

final class Str
{
    public static function studly(string $value): string
    {
        $value = ucwords(preg_replace('/[^a-zA-Z0-9]/s', ' ', $value));

        return str_replace(' ', '', $value);
    }

    public static function camel(string $value): string
    {
        return lcfirst(self::studly($value));
    }
}
