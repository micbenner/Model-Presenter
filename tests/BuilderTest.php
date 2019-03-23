<?php

namespace Tests;

use Micbenner\ModelPresenter\Builder;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    public function testAddAttribute()
    {
        $b = $this->b()->add('test', true);

        $this->assertEquals(['test' => true], $b->getAttributes());
    }

    public function testWhen()
    {
        $b = $this->b()
                  ->when(true, 'true', true)
                  ->when(false, 'false', true)
                  ->when(true, 'ctrue', function () {
                      return 'yes';
                  });

        $this->assertEquals(['true' => true, 'ctrue' => 'yes'], $b->getAttributes());
    }

    private function b(): Builder
    {
        return new Builder();
    }
}