<?php

namespace App\Factory;

use App\Entity\Event;
use App\Repository\EventRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Event>
 *
 * @method        Event|Proxy                     create(array|callable $attributes = [])
 * @method static Event|Proxy                     createOne(array $attributes = [])
 * @method static Event|Proxy                     find(object|array|mixed $criteria)
 * @method static Event|Proxy                     findOrCreate(array $attributes)
 * @method static Event|Proxy                     first(string $sortedField = 'id')
 * @method static Event|Proxy                     last(string $sortedField = 'id')
 * @method static Event|Proxy                     random(array $attributes = [])
 * @method static Event|Proxy                     randomOrCreate(array $attributes = [])
 * @method static EventRepository|RepositoryProxy repository()
 * @method static Event[]|Proxy[]                 all()
 * @method static Event[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Event[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Event[]|Proxy[]                 findBy(array $attributes)
 * @method static Event[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Event[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Event> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Event> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Event> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Event> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Event> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Event> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Event> random(array $attributes = [])
 * @phpstan-method static Proxy<Event> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Event> repository()
 * @phpstan-method static list<Proxy<Event>> all()
 * @phpstan-method static list<Proxy<Event>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Event>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Event>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Event>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Event>> randomSet(int $number, array $attributes = [])
 */
final class EventFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'status' => self::faker()->boolean(),
            'title' => self::faker()->realTextBetween(10, 50),
            'description' => self::faker()->realTextBetween(30, 255)
        ];
    }

    protected static function getClass(): string
    {
        return Event::class;
    }
}
