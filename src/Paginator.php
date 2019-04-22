<?php

namespace Micbenner\ModelPresenter;

interface Paginator
{
    /**
     * Get the current page of the paginator
     *
     * @return int
     */
    public function getCurrentPage(): int;

    /**
     * Get the items to iterate over
     *
     * @return iterable
     */
    public function getItems(): iterable;
}