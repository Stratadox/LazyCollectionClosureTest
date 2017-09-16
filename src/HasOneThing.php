<?php

namespace Stratadox\ModelMapper;

class HasOneThing
{
    private $thing;

    public function __construct(Thing $thing)
    {
        $this->thing = $thing;
    }

    public function thing() : Thing
    {
        return $this->thing;
    }
}
