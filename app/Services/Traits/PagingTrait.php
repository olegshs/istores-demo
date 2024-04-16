<?php

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Builder;

trait PagingTrait
{
    private const DefaultPerPage = 100;

    private ?int $page = null;
    private ?int $perPage = null;

    public function forPage(int $page = 1, int $perPage = self::DefaultPerPage): self
    {
        $clone = clone $this;
        $clone->page = $page;
        $clone->perPage = $perPage;

        return $clone;
    }

    private function addPaging(Builder $builder): void
    {
        if (isset($this->page)) {
            $builder->forPage($this->page, $this->perPage ?? self::DefaultPerPage);
        }
    }
}
