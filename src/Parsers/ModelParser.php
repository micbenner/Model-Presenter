<?php

namespace Micbenner\ModelPresenter\Parsers;

class ModelParser implements Parser
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function isMany(): bool
    {
        return false;
    }

    public function parse(callable $build)
    {
        if (is_null($this->model)) {
            return null;
        }

        return $build($this->model);
    }

    public function with(): array
    {
        return [];
    }
}