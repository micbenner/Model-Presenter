<?php

namespace Micbenner\ModelPresenter;

use Doctrine\Common\Inflector\Inflector;
use JsonSerializable;
use Micbenner\ModelPresenter\Parsers\Parser;

abstract class Presenter implements PresenterMap, JsonSerializable
{
    private $parser;
    private $flatten;

    public function __construct(Parser $parser, $flatten = false)
    {
        $this->parser  = $parser;
        $this->flatten = $flatten;
    }

    public static function make($data)
    {
        return new static(ParserFactory::build($data));
    }

    public static function flat($data)
    {
        return new static(ParserFactory::build($data), true);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): ?array
    {
        $build = function ($model) {
            return $this->build(new Builder, $model)->getAttributes();
        };

        $parsed = $this->parser->parse($build);

        if ($this->flatten) {
            return $parsed;
        }

        return array_merge([
                               $this->parser->isMany() ? $this->dataKeyAsPlural() : $this->dataKey() => $parsed
                           ],
                           $this->parser->with()
        );
    }

    protected function dataKeyAsPlural(): string
    {
        return Inflector::pluralize($this->dataKey());
    }
}