<?php

namespace App\Factory;

use App\Entity\Availability;
use App\Repository\AvailabilityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Availability>
 *
 * @method        Availability|Proxy                     create(array|callable $attributes = [])
 * @method static Availability|Proxy                     createOne(array $attributes = [])
 * @method static Availability|Proxy                     find(object|array|mixed $criteria)
 * @method static Availability|Proxy                     findOrCreate(array $attributes)
 * @method static Availability|Proxy                     first(string $sortedField = 'id')
 * @method static Availability|Proxy                     last(string $sortedField = 'id')
 * @method static Availability|Proxy                     random(array $attributes = [])
 * @method static Availability|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AvailabilityRepository|RepositoryProxy repository()
 * @method static Availability[]|Proxy[]                 all()
 * @method static Availability[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Availability[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Availability[]|Proxy[]                 findBy(array $attributes)
 * @method static Availability[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Availability[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Availability> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Availability> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Availability> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Availability> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Availability> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Availability> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Availability> random(array $attributes = [])
 * @phpstan-method static Proxy<Availability> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Availability> repository()
 * @phpstan-method static list<Proxy<Availability>> all()
 * @phpstan-method static list<Proxy<Availability>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Availability>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Availability>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Availability>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Availability>> randomSet(int $number, array $attributes = [])
 */
final class AvailabilityFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        $date = self::faker()->dateTimeBetween('-5 years', '+5 years');

        $days = range(
            1,
            $date->format('t')
        );
        $days = self::faker()->randomElements(
            $days,
            self::faker()->numberBetween(
                1,
                $date->modify('last day of this month')->format('t')
            )
        );

        sort($days);

        return [
            'year' => $date->format('Y'),
            'month' => $date->format('n'),
            'days' => $days,
        ];
    }

    protected static function getClass(): string
    {
        return Availability::class;
    }
}
