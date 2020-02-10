<?php
declare(strict_types=1);

namespace App\Model;

class Post
{
    private $id;
    private $category;
    private $title;
    private $shortDescription;
    private $image;
    private $publicationDate;

    public function __construct(int $id, Category $category, string $title)
    {
        $this->id = $id;
        $this->category = $category;
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @param mixed $shortDescription
     * @return Post
     */
    public function setShortDescription($shortDescription): self
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Post
     */
    public function setImage($image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublicationDate(): ?\DateTime
    {
        return $this->publicationDate;
    }

    /**
     * @param \DateTime $publicationDate
     * @return Post
     */
    public function setPublicationDate(\DateTime $publicationDate): self
    {
        $this->publicationDate = $publicationDate;
        return $this;
    }

}