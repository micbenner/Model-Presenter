<?php

namespace Tests;

use Micbenner\ModelPresenter\Builder;
use Micbenner\ModelPresenter\Parsers\ModelParser;
use Micbenner\ModelPresenter\Presentable;
use Micbenner\ModelPresenter\Presenter;
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

    public function testAddChildPresenterWithKey()
    {
        /*$parser    = $this->getMockBuilder(ModelParser::class)->setConstructorArgs(['things'])->getMock();
        $presenter = $this->getMockBuilder(Presenter::class)->setConstructorArgs([$parser])->getMock();
        $presenter->method('dataKey')->willReturn('child');
        $presenter->method('build')->willReturn(
            $this->b()->add('kid', true)
        );*/

        $presenter = $this->getMockBuilder(Presenter::class)->setConstructorArgs([[]])->getMock();
        $presenter->method('toArray')->willReturn([
                                                      'child' => [
                                                          'kid' => true,
                                                      ]
                                                  ]);

        $b = $this->b()
                  ->addPresenter($presenter);

        $this->assertEquals(['child' => ['kid' => true]], $b->getAttributes());
    }

    private function b(): Builder
    {
        return new Builder();
    }
}