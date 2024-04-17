<?php

namespace App\Factory;

use App\Entity\Veiculo;
use App\Repository\VeiculoRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Veiculo>
 *
 * @method        Veiculo|Proxy create(array|callable $attributes = [])
 * @method static Veiculo|Proxy createOne(array $attributes = [])
 * @method static Veiculo|Proxy find(object|array|mixed $criteria)
 * @method static Veiculo|Proxy findOrCreate(array $attributes)
 * @method static Veiculo|Proxy first(string $sortedField = 'id')
 * @method static Veiculo|Proxy last(string $sortedField = 'id')
 * @method static Veiculo|Proxy random(array $attributes = [])
 * @method static Veiculo|Proxy randomOrCreate(array $attributes = [])
 * @method static VeiculoRepository|RepositoryProxy repository()
 * @method static Veiculo[]|Proxy[] all()
 * @method static Veiculo[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Veiculo[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Veiculo[]|Proxy[] findBy(array $attributes)
 * @method static Veiculo[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Veiculo[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class VeiculoFactory extends ModelFactory
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

        $dateYear = $faker->dateTimeThisYear('now', 'America/Sao_Paulo');

        return [
            'createdAt' => \DateTimeImmutable::createFromMutable($dateYear),
            'crlv' => $faker->unique(11)->numberBetween(10000000000, 99999999999),
            'nomeDoProprietario' => $faker->name(),
            'tipo' => $faker->randomElement([
                'Caminhões Leves', 
                'Caminhões Pesados', 
                'Veículos de Carga Especializada', 
                'Veículos de Entrega Expressa', 
                'Veículos de Transporte Intermodal', 
                'Veículos Autônomos'
            ]),
            'updatedAt' => \DateTimeImmutable::createFromMutable($dateYear),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Veiculo $veiculo): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Veiculo::class;
    }
}
