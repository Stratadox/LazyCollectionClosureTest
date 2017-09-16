<?php

namespace Stratadox\ModelMapper\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\ModelMapper\HasManyThings;
use Stratadox\ModelMapper\HasOneThing;
use Stratadox\ModelMapper\Thing;
use Stratadox\ModelMapper\ThingProxy;

class UpdatingTheProxiesTest extends TestCase
{
    /** @test */
    function entity_property_changes_after_accessing_the_relation()
    {
        $foo = ThingProxy::for('Foo');

        $entity = new HasOneThing($foo);

        $foo->attachTo($entity, 'thing');

        $this->assertInstanceOf(ThingProxy::class, $entity->thing());
        $this->assertSame('Foo', (string) $entity->thing());
        $this->assertNotInstanceOf(ThingProxy::class, $entity->thing());
    }

    /** @test */
    function entity_collection_value_changes_after_accessing_the_relation()
    {
        $bar = ThingProxy::for('Bar');
        $baz = ThingProxy::for('Baz');

        $entity = new HasManyThings($bar, $baz);

        $bar->attachTo($entity, 'things', 0);
        $baz->attachTo($entity, 'things', 1);

        $this->assertInstanceOf(ThingProxy::class, $entity->thing(0));
        $this->assertSame('Bar', (string) $entity->thing(0));
        $this->assertNotInstanceOf(ThingProxy::class, $entity->thing(0));
        $this->assertInstanceOf(ThingProxy::class, $entity->thing(1));
    }

    /** @test */
    function eagerly_loaded_collection_changes_after_accessing_one_of_the_relations()
    {
        $bar = ThingProxy::for('Bar');
        $baz = ThingProxy::for('Baz');

        $entity = new HasManyThings($bar, $baz);

        $bar->attachTo($entity, 'things', 0);
        $bar->eagerLoad(new Thing('Bar'), new Thing('Baz'));
        $baz->attachTo($entity, 'things', 1);
        $baz->eagerLoad(new Thing('Bar'), new Thing('Baz'));

        $this->assertInstanceOf(ThingProxy::class, $entity->thing(0));
        $this->assertSame('Bar', (string) $entity->thing(0));
        $this->assertNotInstanceOf(ThingProxy::class, $entity->thing(0));
        $this->assertNotInstanceOf(ThingProxy::class, $entity->thing(1));
    }
}
