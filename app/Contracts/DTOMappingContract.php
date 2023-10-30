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

    /**
     * return mapped data in form of assoc array
     * 
     * @return Collection|array
     */
    public function transformedData(): array|Collection;

    
    //TODO implement ArrayAccess for DTOs
}
