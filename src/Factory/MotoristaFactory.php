<?php

namespace App\Factory;

use App\Entity\Cnh;
use App\Entity\Motorista;
use App\Repository\MotoristaRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Motorista>
 *
 * @method        Motorista|Proxy create(array|callable $attributes = [])
 * @method static Motorista|Proxy createOne(array $attributes = [])
 * @method static Motorista|Proxy find(object|array|mixed $criteria)
 * @method static Motorista|Proxy findOrCreate(array $attributes)
 * @method static Motorista|Proxy first(string $sortedField = 'id')
 * @method static Motorista|Proxy last(string $sortedField = 'id')
 * @method static Motorista|Proxy random(array $attributes = [])
 * @method static Motorista|Proxy randomOrCreate(array $attributes = [])
 * @method static MotoristaRepository|RepositoryProxy repository()
 * @method static Motorista[]|Proxy[] all()
 * @method static Motorista[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Motorista[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Motorista[]|Proxy[] findBy(array $attributes)
 * @method static Motorista[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Motorista[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class MotoristaFactory extends ModelFactory
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
        $faker = \Faker\Factory::create('pt_BR');

        $cnh = new Cnh();
        $cnh->setNumero($faker->unique(11)->numberBetween(10000000000, 99999999999));
        $cnh->setValidade($faker->dateTimeBetween('now', '+10 years', 'America/Sao_Paulo'));
        $cnh->setCategoria($faker->randomElement(['A', 'B', 'C', 'D', 'E']));

        $dateYear = $faker->dateTimeThisYear('now', 'America/Sao_Paulo');
        return [
            'cnh' => $cnh,
            'cpf' => $faker->cpf(false),
            'createdAt' => \DateTimeImmutable::createFromMutable($dateYear),
            'dataNascimento' => $faker->dateTimeBetween('-30 years', '-18 years', 'America/Sao_Paulo'),
            'nome' => $faker->name(),
            'rg' => $faker->rg(false),
            'updatedAt' => \DateTimeImmutable::createFromMutable($dateYear),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Motorista $motorista): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Motorista::class;
    }
}
