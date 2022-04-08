<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    public function doSomething(): void
    {
        $this->assertTrue(true);
    }
}
