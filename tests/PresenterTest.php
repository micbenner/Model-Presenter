<?php

namespace Tests;

use Micbenner\ModelPresenter\Builder;
use Micbenner\ModelPresenter\Parsers\ArrayParser;
use Micbenner\ModelPresenter\Parsers\ModelParser;
use Micbenner\ModelPresenter\Parsers\Parser;
use Micbenner\ModelPresenter\Presenter;
use PHPUnit\Framework\TestCase;

class PresenterTest extends TestCase
{
    public function testPresentsOneModel()
    {
        $model = [
            'this' => 'is',
            'a'    => 'test',
        ];

        $this->assertEquals(['test' => $model], $this->echoPresenterMock(new ModelParser($model))->toArray());
    }

    public function testPresentsManyModels()
    {
        $models = [
            [
                'this' => 'is',
                'a'    => 'test',
            ],
            [
                'and' => 'so',
                'is'  => 'this',
            ]
        ];

        $this->assertEquals(['tests' => $models], $this->echoPresenterMock(new ArrayParser($models))->toArray());
    }

    private function echoPresenterMock(Parser $parser): Presenter
    {
        $presenter = $this->getMockBuilder(Presenter::class)
                          ->setConstructorArgs([$parser])
                          ->setMethods(['dataKey', 'build'])
                          ->getMock();
        $presenter->method('dataKey')->willReturn('test');
        $presenter->method('build')->willReturnCallback(function ($b, $d) {
            return new Builder($d);
        });

        return $presenter;
    }
}