<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface DTOMappingContract
{
    /**
     * Define attributes mapping compatible to your application entities
     *
     * @return Collection|array
     */
    public function mapInto() : Collection|array;
}
