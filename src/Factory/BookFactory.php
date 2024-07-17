<?php

namespace App\Factory;

use App\Entity\Book;
use App\Enum\BookStatus;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use App\Repository\BookRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;


/**
 * @extends PersistentProxyObjectFactory<Book>
 */
final class BookFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Book::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'Cover' => self::faker()->imageUrl(330, 500, 'couverture', true),
            'EditedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'ISBN' => self::faker()->isbn13(),
            'PageNumber' => self::faker()->randomNumber(),
            'Plot' => self::faker()->text(),
            'Status' => self::faker()->randomElement(BookStatus::cases()),
            'Title' => self::faker()->unique()->sentence(),
            'createdBy' => UserFactory::new(),
            'editor' => EditorFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Book $book): void {})
        ;
    }
}
