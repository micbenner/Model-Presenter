<?php

namespace Tests;

use Micbenner\ModelPresenter\ParserFactory;
use Micbenner\ModelPresenter\Parsers\ArrayParser;
use Micbenner\ModelPresenter\Parsers\ModelParser;
use Micbenner\ModelPresenter\Presentable;
use PHPUnit\Framework\TestCase;
use Traversable;

class ParserFactoryTest extends TestCase
{
    public function testMakesModelParserWithNull()
    {
        $this->assertInstanceOf(ModelParser::class, $this->factory()->buildParser(null));
    }

    public function testMakesModelParserWithPresentable()
    {
        $presentable = $this->getMockBuilder(Presentable::class)->getMock();

        $this->assertInstanceOf(ModelParser::class, $this->factory()->buildParser($presentable));
    }

    public function testMakesArrayParserWithTraversable()
    {
        $traversable = $this->getMockBuilder(Traversable::class)->getMock();

        $this->assertInstanceOf(ArrayParser::class, $this->factory()->buildParser($traversable));
    }

    public function testMakesArrayParserWithArray()
    {
        $array = [];

        $this->assertInstanceOf(ArrayParser::class, $this->factory()->buildParser($array));
    }

    public function testThrowsExceptionWithUnknown()
    {
        $this->expectExceptionMessage("Initial data given to Presenter incompatible");

        $this->factory()->buildParser('unknown');
    }

    private function factory()
    {
        return new ParserFactory;
    }
}