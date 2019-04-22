<?php

namespace Micbenner\ModelPresenter\Parsers;

use Micbenner\ModelPresenter\Paginator;

class PaginatorParser implements Parser
{
    private $paginator;
    private $arrayParser;

    public function __construct(Paginator $paginator)
    {
        $this->paginator   = $paginator;
        $this->arrayParser = new ArrayParser($paginator->getItems());
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
        return $this->arrayParser->parse($build);
    }

    /**
     * An array of items to always include with the final presented array
     *
     * @return array
     */
    public function with(): array
    {
        $paginator = [
            'currentPage' => $this->paginator->getCurrentPage(),
        ];

        return compact('paginator');
    }

    /*
    // old method, for reference
    public function with(): array
    {
        $paginator = [
            'current_page' => $this->paginator->currentPage(),
            //'first_page_url' => $this->paginator->url(1),
            //'from'           => $this->paginator->firstItem(),
            //'next_page_url'  => $this->paginator->nextPageUrl(),
            //'per_page'       => $this->paginator->perPage(),
            //'prev_page_url'  => $this->paginator->previousPageUrl(),
            //'to'             => $this->paginator->lastItem(),
        ];

        if ($this->paginator instanceof LengthAwarePaginator) {
            $paginator = array_merge($paginator, [
                'last_page' => $this->paginator->lastPage(),
                //'last_page_url' => $this->paginator->url($this->paginator->lastPage()),
                //'total'         => $this->paginator->total(),
            ]);
        }

        return array_merge($this->arrayParser->with(), compact('paginator'));
    }*/
}