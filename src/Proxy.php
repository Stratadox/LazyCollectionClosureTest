<?php

namespace Stratadox\ModelMapper;

interface Proxy
{
    /**
     * Tell the proxy it belongs to a certain field of a certain object.
     * When loading the proxy, the specified field will be updated with an
     * object of the real class.
     *
     * @param object $object
     * @param string $field
     * @param int|null $index
     * @return void
     */
    function attachTo($object, string $field, int $index = null);

    /**
     * If the proxy belongs to a collection (ie. an array or an ArrayAccess
     * implementing collection class)
     * @param object[] ...$objects
     * @return void
     */
    function eagerLoad(...$objects);
}
