<?php

declare(strict_types=1);

namespace Tests\Utils;

use GildedRose\Utils\Str;
use Tests\AbstractTestCase;
use TypeError;

class StrUtilTest extends AbstractTestCase
{
    public function testCanNotStudlyWithInputNotString()
    {
        $input = $this->faker->randomElement([2, 2.5, true, false]);

        $this->expectException(TypeError::class);

        Str::studly($input);
    }

    public function testCanStudlyWithDashes()
    {
        $str = 'foo-bar_lorem-Fore_Fun';

        $result = Str::studly($str);

        $this->assertEquals('FooBarLoremForeFun', $result);
    }

    public function testCanStudlyWithoutDashes()
    {
        $str = 'foo)bar(lorem+Fore.Fun?three';

        $result = Str::studly($str);

        $this->assertEquals('FooBarLoremForeFunThree', $result);
    }

    public function testCanStudlyWithSpecialChar()
    {
        $str = "forTest,to remove<the>Special'Char;";

        $result = Str::studly($str);

        $this->assertEquals('ForTestToRemoveTheSpecialChar', $result);
    }

    public function testCanStudlyWithSpace()
    {
        $str = "forDouble Test,space          remove<the>          Now  'Char;";

        $result = Str::studly($str);

        $this->assertEquals('ForDoubleTestSpaceRemoveTheNowChar', $result);
    }

    public function testCanNotCamelWithInputNotString()
    {
        $input = $this->faker->randomElement([2, 2.5, true, false]);

        $this->expectException(TypeError::class);

        Str::camel($input);
    }

    public function testCanCamelWithDashes()
    {
        $str = 'foo-bar_lorem-Fore_Fun';

        $result = Str::camel($str);

        $this->assertEquals('fooBarLoremForeFun', $result);
    }

    public function testCanCamelWithSpecialChar()
    {
        $str = "forTest,to remove<the>Special'Char;";

        $result = Str::camel($str);

        $this->assertEquals('forTestToRemoveTheSpecialChar', $result);
    }

    public function testCanCamelWithSpace()
    {
        $str = "forDouble Test,space          remove<the>          Now  'Char;";

        $result = Str::camel($str);

        $this->assertEquals('forDoubleTestSpaceRemoveTheNowChar', $result);
    }
}
