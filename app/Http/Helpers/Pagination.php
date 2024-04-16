<?php

namespace App\Http\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class Pagination
{
    public static function resolve(callable $callback)
    {
        $page = request()->input('page', 1);
        $perPage = request()->input('perPage', 20);
        $url = request()->url();
        $query = request()->query();

        return $callback($page, $perPage, $url, $query);
    }

    public static function make(int $total, callable $getItems): LengthAwarePaginator
    {
        return static::resolve(function ($page, $perPage, $url, $query) use ($total, $getItems) {
            $paginator = new LengthAwarePaginator(
                $getItems($page, $perPage),
                $total,
                $perPage,
                $page,
            );
            $paginator->setPath($url);
            $paginator->appends($query);

            return $paginator;
        });
    }
}
