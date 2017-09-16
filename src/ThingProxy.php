<?php

namespace Stratadox\ModelMapper;

class ThingProxy extends Thing implements Proxy
{
    use Proxying;

    function __toString()
    {
        return $this->load(__FUNCTION__);
    }
}
