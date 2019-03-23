<?php

namespace Micbenner\ModelPresenter;

interface PresenterMap
{
    /**
     * The key to use when presenting this model
     *
     * @return string
     */
    public function dataKey(): string;

    /**
     * Build the model attributes
     *
     * @param Builder $b
     * @param mixed $model
     * @return Builder
     */
    public function build(Builder $b, $model): Builder;
}