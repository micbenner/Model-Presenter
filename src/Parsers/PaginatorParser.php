<?php

namespace App\Presentation\Parsers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;

class PaginatorParser implements Parser
{
    private $paginator;
    private $arrayParser;

    /**
     * PaginatorParser constructor.
     *
     * @param \Illuminate\Contracts\Pagination\Paginator $paginator
     */
    public function __construct(Paginator $paginator)
    {
        $this->paginator   = $paginator;
        $this->arrayParser = new ArrayParser($paginator);
    }

    public function dataType()
    {
        $this->arrayParser->dataType();
    }

    public function parse(callable $build)
    {
        return $this->arrayParser->parse($build);
    }

    // todo
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
    }
}