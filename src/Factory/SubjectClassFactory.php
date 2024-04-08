<?php

namespace App\Factory;

use App\Entity\SubjectClass;
use App\Repository\SubjectClassRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<SubjectClass>
 *
 * @method        SubjectClass|Proxy                     create(array|callable $attributes = [])
 * @method static SubjectClass|Proxy                     createOne(array $attributes = [])
 * @method static SubjectClass|Proxy                     find(object|array|mixed $criteria)
 * @method static SubjectClass|Proxy                     findOrCreate(array $attributes)
 * @method static SubjectClass|Proxy                     first(string $sortedField = 'id')
 * @method static SubjectClass|Proxy                     last(string $sortedField = 'id')
 * @method static SubjectClass|Proxy                     random(array $attributes = [])
 * @method static SubjectClass|Proxy                     randomOrCreate(array $attributes = [])
 * @method static SubjectClassRepository|RepositoryProxy repository()
 * @method static SubjectClass[]|Proxy[]                 all()
 * @method static SubjectClass[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static SubjectClass[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static SubjectClass[]|Proxy[]                 findBy(array $attributes)
 * @method static SubjectClass[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static SubjectClass[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class SubjectClassFactory extends ModelFactory
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
            'date' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(SubjectClass $subjectClass): void {})
        ;
    }

    protected static function getClass(): string
    {
        return SubjectClass::class;
    }
}
