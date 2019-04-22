<?php

namespace Micbenner\ModelPresenter;

use Micbenner\ModelPresenter\Parsers\ArrayParser;
use Micbenner\ModelPresenter\Parsers\ModelParser;
use Micbenner\ModelPresenter\Parsers\PaginatorParser;
use Micbenner\ModelPresenter\Parsers\Parser;
use Traversable;

class ParserFactory
{
    public static function build($data): Parser
    {
        return (new static)->buildParser($data);
    }

    public function buildParser($data): Parser
    {
        if (is_null($data) || $data instanceof Presentable) {
            return new ModelParser($data);
        }

        if ($data instanceof Paginator) {
            return new PaginatorParser($data);
        }

        if ($data instanceof Traversable || is_array($data)) {
            return new ArrayParser($data);
        }

        throw new \RuntimeException("Initial data given to Presenter incompatible");
    }
}