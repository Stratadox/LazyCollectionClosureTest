<?php

namespace Stratadox\ModelMapper;

class Thing
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    function __toString()
    {
        return $this->value;
    }
}
