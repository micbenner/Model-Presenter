<?php

namespace Micbenner\ModelPresenter;

interface PresentableCollectionWith extends PresentableCollection
{
    /**
     * Items to always append onto the final presenter
     *
     * @return array
     */
    public function getWith(): array;
}