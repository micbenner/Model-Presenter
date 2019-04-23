<?php

namespace Tests;

use Micbenner\ModelPresenter\Builder;
use Micbenner\ModelPresenter\Paginator;
use Micbenner\ModelPresenter\Parsers\ArrayParser;
use Micbenner\ModelPresenter\Parsers\CollectionParser;
use Micbenner\ModelPresenter\Parsers\ModelParser;
use Micbenner\ModelPresenter\Parsers\PaginatorParser;
use Micbenner\ModelPresenter\Parsers\Parser;
use Micbenner\ModelPresenter\PresentableCollectionWith;
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
            ],
        ];

        $this->assertEquals(['tests' => $models], $this->echoPresenterMock(new ArrayParser($models))->toArray());
    }

    public function testPresentsPaginator()
    {
        $models = [
            [
                'this' => 'is',
                'a'    => 'test',
            ],
            [
                'and' => 'so',
                'is'  => 'this',
            ],
        ];

        $paginator = $this->getMockBuilder(PresentableCollectionWith::class)
                          ->setMethods(['getItems', 'getWith'])
                          ->getMock();
        $paginator->method('getItems')->willReturn($models);
        $paginator->method('getWith')->willReturn(['paginator' => ['currentPage' => 1]]);

        $expected = [
            'tests'     => $models,
            'paginator' => [
                'currentPage' => 1,
            ],
        ];

        $this->assertEquals($expected, $this->echoPresenterMock(new CollectionParser($paginator))->toArray());
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