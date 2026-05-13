<?php
// Fixed: original used Pest's test() function but Pest is not installed; converted to PHPUnit class

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function test_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}
