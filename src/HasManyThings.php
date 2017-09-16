<?php

namespace Stratadox\ModelMapper;

class HasManyThings
{
    private $things;

    public function __construct(Thing ...$things)
    {
        $this->things = $things;
    }

    public function thing(int $i) : Thing
    {
        return $this->things[$i];
    }
}
