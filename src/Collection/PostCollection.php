<?php


namespace App\Collection;


use App\Model\Post;
use Exception;
use IteratorAggregate;
use Traversable;

final class PostCollection implements IteratorAggregate
{
    private $posts;

    public function __construct(Post ...$posts)
    {
        $this->posts = $posts;
    }

    /**
     * @param Post $post
     */
    public function addPost(Post $post): void
    {
        $this->posts[] = $post;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->posts);
    }
}