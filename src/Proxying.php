<?php

namespace Stratadox\ModelMapper;

use Closure;

trait Proxying
{
    private $loader;
    private $field;
    private $index;
    private $eagerLoad = [];

    public function __construct(...$values)
    {
        /**
         * @todo Inject loader instead of instantiating here.
         * Requires a proxy builder, since static constructor methods have no
         * $this scope, which is required when binding the loader to the entity.
         */
        $class = get_parent_class(get_called_class());
        $setter = $this->getSetter();
        $this->loader = function (
            string $method,
            string $field = null,
            string $index = null,
            array $eagerLoad = null
        ) use (
            $class,
            $values,
            $setter
        ) {
            $inst = new $class(...$values);
            $setter = $setter->bindTo($this, $this);
            $setter($inst, $field, $index, $eagerLoad);
            return $inst->$method();
        };
    }

    /**
     * @param array ...$values Constructor arguments
     * @return static|Proxy
     */
    public static function for(...$values) : Proxy
    {
        return new static(...$values);
    }

    /**
     * @param object $object
     * @param string $field
     * @param int|null $index
     */
    public function attachTo($object, string $field, int $index = null)
    {
        $this->loader = $this->loader->bindTo($object, $object);
        $this->field = $field;
        $this->index = $index;
    }

    /**
     * @param array ...$objects To replace the collection values with
     * @todo load collection loader instead
     */
    public function eagerLoad(...$objects)
    {
        $this->eagerLoad = $objects;
    }

    private function load(string $method)
    {
        return ($this->loader)($method, $this->field, $this->index, $this->eagerLoad);
    }

    /**
     * @return Closure
     */
    private function getSetter()
    {
        return function (
            $inst,
            string $field = null,
            string $index = null,
            array $eagerLoad
        ) {
            if (is_null($field)) {
                return;
            }
            if (!empty($eagerLoad)) {
                $this->$field = $eagerLoad;
                return;
            }
            if (is_null($index)) {
                $this->$field = $inst;
            } else {
                $this->$field[$index] = $inst;
            }
        };
    }
}
