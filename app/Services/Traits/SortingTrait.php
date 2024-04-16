<?php

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SortingTrait
{
    private const DefaultOrderDirection = 'asc';

    private ?string $orderBy = null;
    private ?string $orderDirection = null;

    public function orderBy(string $column, string $direction = self::DefaultOrderDirection): self
    {
        $clone = clone $this;
        $clone->orderBy = $column;
        $clone->orderDirection = $direction;

        return $clone;
    }

    private function addSorting(Builder $builder): void
    {
        if (isset($this->orderBy)) {
            $builder->orderBy($this->orderBy, $this->orderDirection ?? self::DefaultOrderDirection);
        }
    }
}
