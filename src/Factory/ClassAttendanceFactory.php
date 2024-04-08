<?php

namespace App\Factory;

use App\Entity\ClassAttendance;
use App\Repository\ClassAttendanceRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<ClassAttendance>
 *
 * @method        ClassAttendance|Proxy                     create(array|callable $attributes = [])
 * @method static ClassAttendance|Proxy                     createOne(array $attributes = [])
 * @method static ClassAttendance|Proxy                     find(object|array|mixed $criteria)
 * @method static ClassAttendance|Proxy                     findOrCreate(array $attributes)
 * @method static ClassAttendance|Proxy                     first(string $sortedField = 'id')
 * @method static ClassAttendance|Proxy                     last(string $sortedField = 'id')
 * @method static ClassAttendance|Proxy                     random(array $attributes = [])
 * @method static ClassAttendance|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ClassAttendanceRepository|RepositoryProxy repository()
 * @method static ClassAttendance[]|Proxy[]                 all()
 * @method static ClassAttendance[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static ClassAttendance[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static ClassAttendance[]|Proxy[]                 findBy(array $attributes)
 * @method static ClassAttendance[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static ClassAttendance[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ClassAttendanceFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'status' => $this->faker()->randomElement(['present', 'absent'])
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(ClassAttendance $classAttendance): void {})
        ;
    }

    protected static function getClass(): string
    {
        return ClassAttendance::class;
    }
}
