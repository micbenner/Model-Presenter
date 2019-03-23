<?php

namespace Micbenner\ModelPresenter\Parsers;

class ArrayParser implements Parser
{
    private $items;

    /**
     * ArrayParser constructor.
     *
     * @param \Traversable[] $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    public function isMany(): bool
    {
        return true;
    }

    public function parse(callable $build)
    {
        $items = [];

        foreach ($this->items as $key => $item) {
            $items[$key] = $build($item);
        }

        return $items;
    }

    public function with(): array
    {
        return [];
    }
}