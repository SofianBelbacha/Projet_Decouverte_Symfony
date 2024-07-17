<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use App\Enum\BookStatus;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[Assert\Isbn(type: 'isbn13')]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 13, max: 13)]
    #[ORM\Column(length: 255)]
    private ?string $ISBN = null;

    #[Assert\NotBlank()]
    #[Assert\Url()]
    #[ORM\Column(length: 255)]
    private ?string $Cover = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $EditedAt = null;

    #[Assert\NotBlank()]
    #[Assert\Length(min: 20)]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $Plot = null;

    #[Assert\NotBlank()]
    #[Assert\Type(type: 'integer')]
    #[Assert\Length(max: 4)]
    #[ORM\Column]
    private ?int $PageNumber = null;

    #[ORM\Column(length: 255)]
    private ?BookStatus $Status = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editor $editor = null;

    /**
     * @var Collection<int, Author>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'books')]
    private Collection $authors;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'book', orphanRemoval: true)]
    private Collection $comments;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $createdBy = null;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): static
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->Cover;
    }

    public function setCover(string $Cover): static
    {
        $this->Cover = $Cover;

        return $this;
    }

    public function getEditedAt(): ?\DateTimeImmutable
    {
        return $this->EditedAt;
    }

    public function setEditedAt(\DateTimeImmutable $EditedAt): static
    {
        $this->EditedAt = $EditedAt;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->Plot;
    }

    public function setPlot(string $Plot): static
    {
        $this->Plot = $Plot;

        return $this;
    }

    public function getPageNumber(): ?int
    {
        return $this->PageNumber;
    }

    public function setPageNumber(int $PageNumber): static
    {
        $this->PageNumber = $PageNumber;

        return $this;
    }

    public function getStatus(): ?BookStatus
    {
        return $this->Status;
    }

    public function setStatus(BookStatus $Status): static
    {
        $this->Status = $Status;

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): static
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addBook($this);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        if ($this->authors->removeElement($author)) {
            $author->removeBook($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setBook($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBook() === $this) {
                $comment->setBook(null);
            }
        }

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
