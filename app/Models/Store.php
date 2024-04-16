<?php

namespace App\Models;

use Illuminate\Contracts\Support\Arrayable;

class Store implements Arrayable
{
    private int $id;
    private array $info;
    private array $categories;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getInfo(): array
    {
        return $this->info;
    }

    public function setInfo(array $info): void
    {
        $this->info = $info;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'info' => $this->getInfo(),
            'categories' => $this->getCategories(),
        ];
    }
}
