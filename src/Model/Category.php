<?php
declare(strict_types=1);

namespace App\Model;

use App\Collection\PostCollection;

class Category
{
    private $id;
    private $slug;
    private $name;
    private $posts;

    public function __construct(int $id, string $slug, string $name)
    {
        $this->id = $id;
        $this->slug = $slug;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return PostCollection
     */
    public function getPosts(): PostCollection
    {
        return $this->posts;
    }

    /**
     * @param PostCollection $posts
     */
    public function setPosts(PostCollection $posts): void
    {
        $this->posts = $posts;
    }
}