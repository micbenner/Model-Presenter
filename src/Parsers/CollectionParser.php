<?php

namespace Micbenner\ModelPresenter\Parsers;

use Micbenner\ModelPresenter\PresentableCollection;
use Micbenner\ModelPresenter\PresentableCollectionWith;

class CollectionParser implements Parser
{
    private $collection;

    public function __construct(PresentableCollection $collection)
    {
        $this->collection = $collection;
    }

    public function isMany(): bool
    {
        return true;
    }

    /**
     * Parse or iterate the Presenter's build function
     *
     * @param callable $build
     * @return mixed
     */
    public function parse(callable $build)
    {
        return (new ArrayParser($this->collection->getItems()))->parse($build);
    }

    /**
     * An array of items to always include with the final presented array
     *
     * @return array
     */
    public function with(): array
    {
        if ($this->collection instanceof PresentableCollectionWith) {
            return $this->collection->getWith();
        }

        return [];
    }
}