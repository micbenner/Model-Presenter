<?php

namespace Micbenner\ModelPresenter;

interface PresentableCollection
{
    /**
     * Get the items to iterate over
     *
     * @return iterable
     */
    public function getItems(): iterable;
}