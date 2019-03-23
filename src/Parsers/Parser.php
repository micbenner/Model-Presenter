<?php

namespace Micbenner\ModelPresenter\Parsers;

interface Parser
{
    /**
     * Boolean value to decide whether this is a singular item or a collection of items
     *
     * @return bool
     */
    public function isMany(): bool;

    /**
     * Parse or iterate the Presenter's build function
     *
     * @param callable $build
     * @return mixed
     */
    public function parse(callable $build);

    /**
     * An array of items to always include with the final presented array
     *
     * @return array
     */
    public function with(): array;
}