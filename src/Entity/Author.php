<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(min: 10)]
    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[Assert\NotBlank()]
    #[ORM\Column]
    private ?\DateTimeImmutable $DateOfBirth = null;

    #[Assert\GreaterThan(propertyPath: 'DateOfBirth')]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $DateOfDeath = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Nationality = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'authors')]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeImmutable
    {
        return $this->DateOfBirth;
    }

    public function setDateOfBirth(\DateTimeImmutable $DateOfBirth): static
    {
        $this->DateOfBirth = $DateOfBirth;

        return $this;
    }

    public function getDateOfDeath(): ?\DateTimeImmutable
    {
        return $this->DateOfDeath;
    }

    public function setDateOfDeath(?\DateTimeImmutable $DateOfDeath): static
    {
        $this->DateOfDeath = $DateOfDeath;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->Nationality;
    }

    public function setNationality(?string $Nationality): static
    {
        $this->Nationality = $Nationality;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addAuthor($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            $book->removeAuthor($this);
        }

        return $this;
    }
}
