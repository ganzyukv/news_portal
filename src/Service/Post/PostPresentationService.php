<?php
declare(strict_types=1);

namespace App\Service\Post;


use App\Model\Post;
use App\Mapper\PostMapper;
use App\Repository\Post\PostRepositoryInterface;

final class PostPresentationService implements PostPresentationInterface
{

    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPost(int $id): ?Post
    {
        $entity = $this->postRepository->findById($id);

        if (null === $entity) {
            return null;
        }

        return PostMapper::entityToModel($entity);
    }
}