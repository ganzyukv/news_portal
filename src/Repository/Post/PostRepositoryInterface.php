<?php
declare(strict_types=1);

namespace App\Repository\Post;

use App\Entity\Post;

interface PostRepositoryInterface
{
    public function findById(int $id): ?Post;

    public function findAllPublished(int $limit, int $offset): ?array;

    public function save(Post $post): void;

}