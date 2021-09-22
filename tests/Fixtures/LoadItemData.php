<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Nelmio\Alice\Loader\NativeLoader;
use Nelmio\Alice\ObjectSet;

class LoadItemData
{
    protected NativeLoader $loader;

    public function __construct()
    {
        $this->loader = new NativeLoader();
    }

    public function loadData($filePath): ObjectSet
    {
        return $this->loader->loadFile($filePath);
    }
}
